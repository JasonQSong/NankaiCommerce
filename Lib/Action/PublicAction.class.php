<?php
// 本类由系统自动生成，仅供测试用途
class PublicAction extends Action {
    public function _base(){
		R('User/_info');
		$this->HierarchyCatagories=R('Sell/_hierachycatagory',array(0));
		$this->AncestorsCatagories=array();
		$this->SubHierarchyCatagories=array();
    }
}
?>