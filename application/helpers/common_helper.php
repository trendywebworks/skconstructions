<?php

function toHeading($slug)
{
	return ucwords(str_replace('_', ' ', $slug));
}

function currentDateTime()
{
    date_default_timezone_get();
    return $date = date('Y-m-d H:i:s');
}

function commonDateFormat($date)
{
  return date('d-m-Y',strtotime($date));
}

function dayDateFormat($date)
{
  return date('d-m-Y',strtotime($date));
}

function toDbDateFormat($date)
{
  if($date === null || $date === '')
  {
    return '';
  }

  $date = trim($date);
  $formats = array('d-m-Y', 'Y-m-d', 'd/m/Y', 'Y/m/d');

  foreach($formats as $format)
  {
    $dt = DateTime::createFromFormat($format, $date);
    if($dt && $dt->format($format) === $date)
    {
      return $dt->format('Y-m-d');
    }
  }

  return date('Y-m-d',strtotime($date));
}

function toDMTDateFormat($date)
{
  return date('m F h:iA',strtotime($date));
}

function start_End_Date_of_a_week()
{
    $monday = strtotime('next Sunday -1 week');
    $monday = date('w', $monday)==date('w') ? strtotime(date("Y-m-d",$monday)." +7 days") : $monday;
    $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
    $dates['start'] = date("Y-m-d",$monday);
    $dates['end'] = date("Y-m-d",$sunday);
    return $dates;
}

function getDropdownOptions($table, $field, $selectid='', $other=0)
{
	$CI = &get_instance();
    $where = array(
        'status'  =>  'active');
    $result = $CI->db->where($where)->get($table)->result_array();

    $option = '<option value="">Select</option>';

    if(isset($result))
    {
        $selected = '';
    	foreach($result as $li)
    	{
            if($selectid!='' && $selectid==$li['id'])
            {
                $selected = 'selected';
            }
            else
            {
                $selected = '';
            }
    		$option .= '<option value="'.$li['id'].'" '.$selected.'>'.$li[$field].'</option>';
    	}
    }
    // if($other==1)
    // {
    //     $option .= '<option value="other">Other</option>';
    // }
    return $option;
}

function getExpenseDropdownOptions($selectid='')
{
    $option = '<option value="">Select</option>
            <option value="income" '.(($selectid!='' && $selectid=='income')?'selected':'').'>Income</option>
            <option value="expense" '.(($selectid!='' && $selectid=='expense')?'selected':'').'>Expense</option>';
    return $option;
}

function getPurchaseDropdownOptions($selectid='')
{
    $option = '<option value="">Select</option>
            <option value="loan" '.(($selectid!='' && $selectid=='loan')?'selected':'').'>Loan</option>
            <option value="cash" '.(($selectid!='' && $selectid=='cash')?'selected':'').'>Cash</option>';
    return $option;
}

function getPositionDropdownOptions($selectid='')
{
    $CI = &get_instance();
    $where = array(
        'status'  =>  'active');
    $result = $CI->db->where($where)->get('roles')->result_array();

    $option = '<option value="">Select</option>';

    if(isset($result))
    {
        $selected = '';
        foreach($result as $li)
        {
            if($selectid!='' && strtolower($selectid)==strtolower($li['name']))
            {
                $selected = 'selected';
            }
            else
            {
                $selected = '';
            }
            $option .= '<option value="'.$li['id'].'" '.$selected.'>'.$li['name'].'</option>';
        }
    }

    return $option;
}
function getLoanTenureOptions($selectid='')
{
    $option = '<option value="">Select</option>
            <option value="1" '.(($selectid!='' && $selectid=='1')?'selected':'').'>1 Month</option>
            <option value="3" '.(($selectid!='' && $selectid=='3')?'selected':'').'>3 Months</option>
            <option value="6" '.(($selectid!='' && $selectid=='6')?'selected':'').'>6 Months</option>
            <option value="12" '.(($selectid!='' && $selectid=='12')?'selected':'').'>12 Months</option>
            <option value="24" '.(($selectid!='' && $selectid=='24')?'selected':'').'>24 Months</option>
            <option value="36" '.(($selectid!='' && $selectid=='36')?'selected':'').'>36 Months</option>
            <option value="48" '.(($selectid!='' && $selectid=='48')?'selected':'').'>48 Months</option>';
    return $option;
}

function getPayTypeDropdownOptions($selectid='')
{
    $option = '<option value="">Select</option>
            <option value="debit" '.(($selectid!='' && $selectid=='debit')?'selected':'').'>Debit</option>
            <option value="credit" '.(($selectid!='' && $selectid=='credit')?'selected':'').'>Credit</option>';
    return $option;
}

function fileUpload($field, $folder)
{
    $uploadData = [];
    $ci = &get_instance(); // need this to resolve the app
    if(!empty($_FILES[$field]['name'])) 
    {
        $_FILES[$field]['name'] = $_FILES[$field]['name'];
        $_FILES[$field]['type'] = $_FILES[$field]['type'];
        $_FILES[$field]['tmp_name'] = $_FILES[$field]['tmp_name'];
        $_FILES[$field]['error'] = $_FILES[$field]['error'];
        $_FILES[$field]['size'] = $_FILES[$field]['size'];
        $config['upload_path'] = './uploads/'.$folder.'/';
        $config['allowed_types'] = 'pdf|doc|txt|jpg|png|jpeg';
        $ci->load->library('upload', $config);
        $ci->upload->initialize($config);
        if($ci->upload->do_upload($field)){
            $fileData = $ci->upload->data();
            $uploadData['file_name'] = $fileData['file_name'];
            $uploadData['created'] = date("Y-m-d H:i:s");
            $uploadData['modified'] = date("Y-m-d H:i:s");

            $ret['status'] = 1;
            $ret['message'] = 'Uploaded successfully';
            $ret['filename'] = $uploadData['file_name'];
        } 
        else 
        {
            $errors = $ci->upload->display_errors();
            // flashMsg($errors);
            $ret['status'] = 2;
            $ret['message'] = $errors;
        }
        return $ret; 
    }
}

function is_logged_in()
{
    $ci = &get_instance();
    $session_data = $ci->session->all_userdata();
    return (isset($session_data['user_id']) && $session_data['user_id'] > 0 && isset($session_data['logged_in']) && $session_data['logged_in'] == TRUE);
}

function numFormat($num)
{
    return '₹'.number_format($num, 0);
}

function is_permitted()
{
    $ci = &get_instance();
    $segment = $ci->uri->segment(1);
    // echo $segment;exit;
    if (!$ci->authorization->check_permission($segment)) {
        redirect('not-permited');
    }
}
?>
