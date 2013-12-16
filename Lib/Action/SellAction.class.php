<?php
class SellAction extends Action {
	public function index(){
		$this->success('正在跳转到添加物品页',U('Sell/additem'));
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
		$data['Description']=sha1(I('post.Description'));
		$data['CatagoryID']=I('post.CatagoryID');
		$data['ImagePath']=I('post.ImagePath');
		$data['BackgroundColor']=I('post.BackgroundColor');
		$data['SellerID']=session('UserID');
	}
	public function hiddenuploadimage(){
		print_r($_FILES['ImageFile']);
		$tmpImagePath=$_FILES['ImageFile']['tmp_name'];
		$this->ImagePath=$tmpImagePath;
		$this->display();
	}
	public function addcatagory(){		
		if(!R('Admin/_confirmadmin')){
			$this->error('没有权限');
			return;
		}
		$Catagories=M('Catagories');
		$CatagoriesRecord=$Catagories->where('1')->select();
		R('Public/_base');
		$this->ExistCatagories=$CatagoriesRecord;
        $this->display();
	}
	public function addcatagorypost(){	
		if(!R('Admin/_confirmadmin')){
			$this->error('没有权限');
			return;
		}
		$data['CatagoryName']=I('post.CatagoryName');
		$data['DisplayName']=I('post.DisplayName');
		$data['BelongTo']=I('post.BelongTo');
		$data['AdminUserID']=session('UserID');		
		$Catagories=M('Catagories');
		$CatagoryRecord=$Catagories->where('CatagoryName='.$data['CatagoryName'])->find();
        if($CatagoryRecord!=null) {
			$this->error('类别名已存在！');
			return;
		}
		$result = $Catagories->add($data);
		if(!$result) {
			$this->error('写入错误！');
		}
		$this->success('类别创建成功！',U('Index/index'));
	}
	public function _hierachycatagory($catagoryid){
		$Catagories=M('Catagories');
		$CatagoriesRecord=$Catagories->where('BelongTo='.$catagoryid)->select();
		if($CatagoriesRecord!=null){
			foreach($CatagoriesRecord as $key => $CatagoryRecord){
				$CatagoriesRecord[$key]['Children']=$this->_hierachycatagory($CatagoryRecord['ID']);
			}
		}
		return $CatagoriesRecord;
	}
	public function _ancestorscatagory($catagoryid){
		if($catagoryid==0)
			return;
		$Catagories=M('Catagories');
		$CatagoryRecord=$Catagories->where('ID='.$catagoryid)->find();
		$AncestorsRecord=$this->_ancestorscatagory($CatagoryRecord['BelongTo']);
		$AncestorsRecord[]=$CatagoryRecord;
		return $AncestorsRecord;
	}	
	public function _scionscatagory($catagoryid){
		$Catagories=M('Catagories');
		$CatagoriesRecord=$Catagories->where('BelongTo='.$catagoryid)->select();
		if($CatagoriesRecord!=null){
			foreach($CatagoriesRecord as $key => $CatagoryRecord){
				$CatagoriesRecord=array_merge($CatagoriesRecord,$this->_scionscatagory($CatagoryRecord['ID']));
			}
		}
		return $CatagoriesRecord;
	}
}
?>