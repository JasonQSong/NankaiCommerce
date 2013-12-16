<?php
class AdminAction extends Action {
    public function index(){
		if(!$this->_confirmadmin()){
			$this->error('没有权限');
			return;
		}
		$this->success('正在跳转到添加类别页',U('Sell/addcatagory'));		
		R('Public/_base');
        $this->display();
    }
	public function _confirmadmin(){
		$UserGroup=R('User/_usergroup');
		return $UserGroup>0;
	}
}
?>