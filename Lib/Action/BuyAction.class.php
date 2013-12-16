<?php
class BuyAction extends Action {
	public function index(){
		$this->success('正在跳转到首页',U('Index/index'));
		R('Public/_base');
        $this->display();
	}
	public function viewcatagory($catagoryid){
		R('Public/_base');
		$this->AncestorsCatagories=R('Sell/_ancestorscatagory',array($catagoryid));
		$this->SubHierarchyCatagories=R('Sell/_hierachycatagory',array($catagoryid));
        $this->display();
	}
	public function additem(){
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
	public function _hierachycatagory($catagoryid){
		$Catagories=M('Catagories');
		$CatagoriesRecord=$Catagories->where('BelongTo='.$catagoryid)->select();
        foreach($CatagoriesRecord as $key => $CatagoryRecord){
			$CatagoriesRecord[$key]['Children']=$this->_hierachycatagory($CatagoryRecord['ID']);
		}
		return $CatagoriesRecord;
	}
}
?>