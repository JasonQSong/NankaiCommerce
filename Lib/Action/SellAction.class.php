<?php
// 本类由系统自动生成，仅供测试用途
class SellAction extends Action {
    public function additem(){
		R('Public/_base');
        $this->display();
    }
	public function index(){
		$this->success('正在跳转到添加物品页',U('Sell/additem'));
		R('Public/_base');
        $this->display();
	}
	public function additempost(){
		$data['ItemName']=I('post.ItemName');
		$data['Description']=sha1(I('post.Description'));
		$data['Catagory']=I('post.Catagory');
		$data['ImageFile']=I('post.ImageFile');
		$data['BackgroundColor']=I('post.BackgroundColor');
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
		print_r( $this->ExistCatagories);
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
}
?>