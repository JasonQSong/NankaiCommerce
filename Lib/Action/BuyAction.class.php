<?php
class BuyAction extends Action {
	public function index(){
		$this->success('正在跳转到首页',U('Index/index'));
		R('Public/_base');
        $this->display();
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
		print_r($ItemsRecord);
		R('Public/_base');
		$this->CatagoryItems=$ItemsRecord;
		$this->AncestorsCatagories=R('Sell/_ancestorscatagory',array($catagoryid));
		$this->SubHierarchyCatagories=R('Sell/_hierachycatagory',array($catagoryid));
        $this->display();
	}
	public function ajaxviewitem($itemid){
		$Items=M('Items');
		$ItemInfo=$Items->where('ID='.$itemid)->find();
		$Actions=M('Actions');
		$SellActionRecord=$Actions->where('ItemID='.$itemid.' and Act=sell')->select();
		$BuyActionRecord=$Actions->where('ItemID='.$itemid.' and Act=buy')->select();
		$data['iteminfo'] = $ItemInfo;
		$data['sellers'] = $SellActionRecord;
		$data['buyers'] = $BuyActionRecord;
		$this->ajaxReturn($data,'JSON');
	}
}
?>