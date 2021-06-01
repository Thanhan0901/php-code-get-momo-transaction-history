<?php  

class Momo_api{
	private  $email;
	private  $password;
	// check input
	function __construct($email='',$password=''){
		if (empty($email)&& empty($password)) { // kiểm tra thông tin 
			echo "\n Bạn chưa nhập đầy đủ thông tin !\n";
			return false;
		}else{
			$this->email = $email; // đưa vào biến obj email để tiện gọi trong các hàm 
			$this->password = $password;
			$data_email = $this->Get_data();
			return $this;
		}
	}

	private function Get_data(){

		$conn = imap_open("{imap.gmail.com:993/debug/imap/ssl/novalidate-cert}INBOX",$this->email, $this->password) or die('Cannot connect to Gmail: ' . imap_last_error());
        $data_email =  imap_search($conn, 'FROM "no-reply@momo.vn"');

        //get data from gmail
        if (! empty($data_email)) {
            foreach ($data_email as $emailIdent) {
                $over_view = imap_fetch_overview($conn, $emailIdent, 0);
               $check = strpos(imap_utf8($over_view[0]->subject),'Bạn vừa nhận được tiền');
                if ($check !==false) {
                	$message = ((imap_fetchbody($conn, $emailIdent,1)));
                	 $message = preg_replace( "/\s+/", " ", $message);

                	
                	print_r($this->Ex_html($message));	
                }
                
        	}
    	}
        imap_close($conn);
	}

	private function Ex_html($html){
		$data = [];
		preg_match_all('/<span\s(.*?)>(.*?)<\/span/is', $html, $name);
		if (isset($name[2][9])) {
			$data['ten_nguoi_gui'] = $name[2][9];
			$data['ma_giao_dich'] = $name[2][4];
		$data['so_tien_nhan_duoc'] = $name[2][2];
		$data['thoi_gian'] = $name[2][6];
		$data['so_dien_thoai'] = $name[2][11];
		$data['loi_nhan'] = $name[2][13];
		}else{
			preg_match_all('/<div\sstyle(.*?)>(.*?)<\/div/is', $html, $name_2);
			$data['ten_nguoi_gui']=  $name_2[2][3];
			$data['ma_giao_dich'] = $name_2[2][11];
			$data['so_tien_nhan_duoc'] = $name_2[2][1];
			$data['thoi_gian'] = $name_2[2][7];
			$data['so_dien_thoai'] = $name_2[2][5];
			$data['loi_nhan'] = $name_2[2][9];
		}

		return $data;

	}
}

$email = 'example@gmail.com';
$password = 'password';
new Momo_api($email,$password);



class Momo_api{
	private  $email; // biến dùng để truyền email 
	private  $password; // biến dùng để truyền password
    //code o day
    
}


$email = 'example@gmail.com';// tai khoản email 
$password = 'password'; // mật khẩu email 
new Momo_api($email,$password); // gọi classs 
?>