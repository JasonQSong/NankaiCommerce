<?php
// 本类由系统自动生成，仅供测试用途
class UserAction extends Action {
    public function register(){
		if(session('UserID')!=''){
		    $this->error('您已登录');
			return;
		}
		$this->display();
    }
	
    public function registerpost(){
		$data['UserName']=I('post.UserName');
		$data['Passwd']=sha1(I('post.Passwd'));
		$data['DisplayName']=I('post.DisplayName');
		$data['FullName']=I('post.FullName');
		$data['Gender']=I('post.Gender');
		$data['Age']=I('post.Age');
		$data['Email']=I('post.Email');
		$data['Telephone']=I('post.Telephone');
		$data['Address']=I('post.Address');
		$data['RegTime']=date('Y-m-d H:i:s');
		$Users=M('Users');
		$UserRecord=$Users->where('UserName='.$data['UserName'])->find();
        if($UserRecord!=null) {
			$this->error('用户名已存在！');
			return;
		}
		$UserRecord=$Users->where('DisplayName='.$data['DisplayName'])->find();
        if($UserRecord!=null) {
			$this->error('昵称已存在！');
			return;
		}
        $Users = M('Users');
		$result = $Users->add($data);
		if(!$result) {
			$this->error('写入错误！');
		}
		session('UserID',$result);
		$this->success('用户创建成功！',U('Index/index'));
    }
	
    public function login(){
		if(session('UserID')!=''){
		    $this->error('您已登录');
			return;
		}
		$this->display();
    }
    public function loginpost(){
		$data['UserName']=I('post.UserName');
		$data['Passwd']=sha1(I('post.Passwd'));
		$Users=M('Users');
		$UserRecord=$Users->where('UserName='.$data['UserName'])->find();
        if($UserRecord==null) {
            $this->error('用户名不存在');
			return;
        }
		$UserPasswd=$UserRecord['Passwd'];
		if($data['Passwd']!=$UserPasswd) {
			$this->error('密码错误！');
			return;
		}
		session('UserID',$UserRecord['ID']);
		$this->success('登录成功！',U('Index/index'));
    }
	
	
	public function logout(){
		session('UserID',null);
		$this->success('您已登出！');
    }
	public function profile(){
		if(session('UserID')==''){
		    $this->error('您尚未登录',U('User/login'));
			return;
		}
		$this->display();
	}
	
	public function _info(){
		$this->IsLogin=session('UserID')!=null;
		if($this->IsLogin){
			$Users=M('Users');
			$UserRecord=$Users->where('ID='.session('UserID'))->find();
			$this->DisplayName=$UserRecord['DisplayName'];
			$this->IsAdmin=R('Admin/_confirmadmin');
			return;
		}
	}
	public function _usergroup(){
		if(session('UserID')=='')
			return -1;
		$Users=M('Users');
		$UserRecord=$Users->where('ID='.session('UserID'))->find();
		return $UserRecord['UserGroup'];
    }
}
?>