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
		$data['Price']=I('post.Price');
		$data['Description']=sha1(I('post.Description'));
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
		$data['Act']='sell';
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
	public function hiddenuploadimage(){
		if(session('UserID')==''){
			$this->UploadException='尚未登陆';
			$this->display();			
			return;
		}
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize = 3145728 ;// 设置附件上传大小
		$upload->allowExts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath = './Images/Items/';// 设置附件上传目录
		$upload->autoSub = true;// 是否使用子目录保存上传文件 
		$upload->subType = 'date';// 子目录创建方式，默认为hash，可以设置为hash或者date
		if(!$upload->upload()) {// 上传错误提示错误信息
			$this->UploadException=$upload->getErrorMsg();
			$this->display();			
			return;
		}
		$info = $upload->getUploadFileInfo();// 上传成功 获取上传文件信息
		$LogImages=M('LogImages');
		$data['UserID']=session('UserID');
		$data['ImagePath']=$info[0]['savename'];
		$result = $LogImages->add($data);
		if(!$result) {
			$this->UploadException='Log写入错误';
			$this->display();			
			return;
		}
		$this->ImagePath=$info[0]['savename'];
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
				$SubCatagoriesRecord=$this->_scionscatagory($CatagoryRecord['ID']);
				if($SubCatagoriesRecord!=null)
					$CatagoriesRecord=array_merge($CatagoriesRecord,$SubCatagoriesRecord);
			}
		}
		return $CatagoriesRecord;
	}
}
?>