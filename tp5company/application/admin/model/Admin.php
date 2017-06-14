<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model
{

    //添加管理员
        public function addAdmin($data)
        {

            if(!empty($data)||is_array($data))
            {
                if(!empty($data['password']))
                {
                    $data['password'] = md5($data['password']);
                }
                $adminData = [
                'username'=>$data['username'],
                'password'=>$data['password']
                ];
               
                 if($this->save($adminData))
                 {
                    $groupData['uid'] =$this->id;  
                    $groupData['group_id'] =$data['group_id'];  
                    // var_dump($groupData);die;
                    db('auth_group_access')->insert($groupData);
                 return true;
                 }else
                {
                return false;
                 }
            }
        }
     //查询管理员带分页
      public  function getAdmin($num)
      {

        return $this::order('id','asc')->paginate($num);
      }
      //查询管理员不带分页
      public  function getAdmin1($id)
      {

        return $this::where('id',$id)->find();
      }
      //修改管理员
      public function editAdmin($data,$db)
      {

       
                 if($data['password']=="")
                {
                    $data['password']=$db['password'];
                }
                else
                {
                     $data['password']=md5($data['password']);
                }
                //更新数据
        
                  $this::save([
                                            'username'  =>$data['username'],
                                            'password'  =>$data['password'],
                                        ],['id' => $data['id']]);
           
                $groupData = [
                      'uid' =>$data['id'],
                      'group_id' =>$data['group_id'],
                                  ];
                      // var_dump($groupData);die;
                  if(db('auth_group_access')->where('uid',$groupData['uid'])->find())
                  {
                  $as=db('auth_group_access')->where('uid',$groupData['uid'])->update($groupData);
                }else
                {
                  $as =   db('auth_group_access')->insert($groupData);
                }
                // var_dump($as);die;
                if( $as!==false)
                  {return true;}
                else{
                  return false;
                }
              
   
         
      }
      //删除数据
      public function del($id)
      {
        $res = $this::where('id',$id)->delete();
        if($res)
        {
            return 1;
        }else
        {
            return 0;
        }
      }
      //管理员登陆
      public function login($data)
      {

        // $res = $this::where('username',$data['username'])->find();
          $res = Admin::getByUsername($data['username']);
          // var_dump($res);die;
          if($res)
          {
              // $res2 = $this::where('password',md5($data['password']))->find();
            
              if($res['password']==md5($data['password']))
              {
                session('id',$res['id']);
                session('username',$res['username']);
                session('password',$res['password']);
                  return 1;
              }else
              {
                  return 2;
              }

          }else
          {
            return 3;
          }
      }

}
