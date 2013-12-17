<?php
class BuyAction extends Action {
	public function index(){
		$this->success('正在跳转到首页',U('Index/index'));
		R('Public/_base');
        $this->display();
	}
    public function additem(){
		if(session('UserID')==''){
		    $this->error('您尚未登录',U('User/login'));
			return;
		}
		$Catagories=M('Catagories');
		$CatagoriesRecord=$Catagories->where('1')->select();
		R('Public/_base');
		$this->ExistCatagories=$CatagoriesRecord;
        $this->display();
    }
	public function additempost(){
		if(session('UserID')==''){
		    $this->error('您尚未登录',U('User/login'));
			return;
		}
		$data['ItemName']=I('post.ItemName');
		$data['Price']=I('post.Price');
		$data['Description']=I('post.Description');
		$data['ImagePath']=I('post.ImagePath');
		$data['BackgroundColor']=I('post.BackgroundColor');
		$data['CatagoryID']=I('post.CatagoryID');
		$Items=M('Items');
		$result = $Items->add($data);
		if(!$result) {
			$this->waitSecond=20;
			$this->error('写入错误！');
			return;
		}
		$data['Act']='buy';
		$data['ItemID']=$result;
		$data['UserID']=session('UserID');
		$Actions=M('Actions');
		$result = $Actions->add($data);
		if(!$result) {
			$this->error('写入错误！');
			return;
		}
		$this->success('添加物品成功',U('Index/index'));
	}
	public function viewcatagory($catagoryid){
		$Items=M('Items');
		$ItemsRecord=$Items->where('CatagoryID='.$catagoryid)->select();
		if($ItemsRecord==null)
			$ItemsRecord=array();
		$ScionsCatagory=R('Sell/_scionscatagory',array($catagoryid));
		if($ScionsCatagory!=null){
			foreach($ScionsCatagory as $key => $CatagoryRecord){
				$CatagoryItemsRecord=$Items->where('CatagoryID='.$ScionsCatagory[$key]['ID'])->select();
				if($CatagoryItemsRecord!=null)
					$ItemsRecord=array_merge($ItemsRecord,$CatagoryItemsRecord);
			}
		}
		R('Public/_base');
		$this->CatagoryItems=$ItemsRecord;
		$this->AncestorsCatagories=R('Sell/_ancestorscatagory',array($catagoryid));
		$this->SubHierarchyCatagories=R('Sell/_hierachycatagory',array($catagoryid));
        $this->display();
	}
	public function ajaxviewitem($itemid){
		$Items=M('Items');
		$ItemInfo=$Items->where('ID='.$itemid)->find();
		$SellerInfo='<a href="'.U('Sell/sellitem?itemid='.$itemid).'">出售给此求购者</a>';
		$BuyerInfo='<a href="'.U('Buy/buyitem?itemid='.$itemid).'">购买此物品</a>';
		$Actions=M('Actions');
		$Users=M('Users');
		$SellActionRecord=$Actions->where('ItemID='.$itemid." and Act='sell'")->find();
		if($SellActionRecord!=null){
			$SellerRecord=$Users->where('ID='.$SellActionRecord['UserID'])->find();
			$SellerInfo='出售者：'.$SellerRecord['DisplayName'];
		}
		$BuyActionRecord=$Actions->where('ItemID='.$itemid." and Act='buy'")->find();
		if($BuyActionRecord!=null){
			$BuyerRecord=$Users->where('ID='.$BuyActionRecord['UserID'])->find();
			$BuyerInfo='求购者：'.$BuyerRecord['DisplayName'];
		}
		$data['iteminfo'] = $ItemInfo;
		$data['SellerInfo'] = $SellerInfo;
		$data['BuyerInfo'] = $BuyerInfo;
		$this->ajaxReturn($data,'JSON');
	}
}
?>