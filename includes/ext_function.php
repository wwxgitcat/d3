<?php
/**
 * Created by hwz@qq.com.
 * User: beecky
 * Date: 2015-10-15
 * 通用扩展函数库
 */
function dis_base_url($full_path = 0)
{
	if ($full_path == 0){
		
		$tpath = "http://".$_SERVER['HTTP_HOST'].'/'.P_PATH;
	}else{
		$tpath = P_PATH;
	}
	$tpath = rtrim($tpath,'/'); //统一过滤路径末尾的'/'
	return $tpath;
}
//显示LOGO
function  dis_logo($str){
	$sitename = $_SERVER['SERVER_NAME'];
	$str = str_replace('_href_', dis_base_url().'/', $str);
	$str = str_replace('_title_', $sitename, $str);
	$str = str_replace('_text_', $sitename, $str);
	return $str;
}
//导航栏
function dis_nav($str){
	$indexname = "";
	$rows = safe_rows('id,name,title','txp_category',"type='article' and name!='' order by id desc limit 6");
	
	foreach($rows as $key=>$val){
		if($key<3){
			$indexname .= $val['title'];
			if($key==2){
				$html = str_replace('_href_',dis_base_url().'/',$str);
				$html = str_replace('_title_',$indexname,$html);
				$html = str_replace('_text_',$indexname,$html); //首页
			}
		}else{
			$href = get_url($val['id'],$val['title'],'cat');
			$title = $val['title'];
			$html_str = str_replace('_href_',$href,$str);
			$html_str = str_replace('_title_',$title,$html_str);
			$html_str = str_replace('_text_',$title,$html_str);
			$html.=$html_str;
		}
	}
	return $html;
}
//----------------------

//面包屑
function dis_bread_crumbs($str,$mstr='&gt;'){
	if(empty($mstr)){
		$mstr='&gt;';
	}
	if (substr($_SERVER['REQUEST_URI'],-1) ==  '/') {
		return '';
	}
	$pstr = '&nbsp;&nbsp;<a href="'.dis_base_url().'" title="'.$_SERVER['HTTP_HOST'].'">'.$_SERVER['HTTP_HOST'].'</a>  ';
	$pstr .= $mstr.' ';
	$r = sp_url();
	if($r){
		if($r['typename']==ART_STR){
			//文章页
			//获取分类链接
			$catname = safe_field('Category1','textpattern','id='.$r['id']);
			$row = safe_row('id,name,parent,title','txp_category',"type='article' and name='".$catname."'");
			if($row){
				if($row['parent']!='' && $row['parent']!='root'){
					//有上级分类
					$row1 = safe_row('id,name,parent,title','txp_category',"type='article' and name='".$row['parent']."'");
					if($row1){
						$url1 = get_url($row1['id'],$row1['title'],'cat');
						$padd = str_replace('_title_',$row1['title'],$str);
						$padd = str_replace('_text_',$row1['title'],$padd);
						$padd = str_replace('_href_',$url1,$padd);
						$pstr.=$padd.' ';
						$pstr .= $mstr.' ';
					}
				}
				$url = get_url($row['id'],$row['title'],'cat');
				$padd = str_replace('_title_',$row['title'],$str);
				$padd = str_replace('_text_',$row['title'],$padd);
				$padd = str_replace('_href_',$url,$padd);
				$pstr.=$padd.' ';
			}
		}elseif($r['typename']==CATE_STR){
			//分类页
            $r['title'] = safe_field('name','txp_category','id=\''.$r['id'].'\'');
			$padd = str_replace('_title_',$r['title'],$str);
			$padd = str_replace('_text_',$r['title'],$padd);
			$padd = str_replace('_href_','#',$padd);
			$pstr.=$padd.' ';
		}
	}
	return $pstr;
}
//文章详情
function dis_detail_article($info,$str){
	$content = str_replace('_title_',$info['title'],$str);
	$content = str_replace('_con_',$info['content'],$content);
	$content = str_replace('_catehref_',$info['catehref'],$content);
	$content = str_replace('_catetitle_',$info['catetitle'],$content);
	return $content;
}
//文章上下篇 0=上一篇，1=下一篇
function dis_up_down($id,$str,$num=0){
	$id = ch_int($id);
	if(empty($num)){
		//上一篇
		$rs = safe_row('ID,Title,url_title','textpattern','`ID`<'.$id.' and `Status`=\'4\' order by ID DESC');
	}else{
		//下一篇
		$rs = safe_row('ID,Title,url_title','textpattern','`ID`>'.$id.' and `Status`=\'4\' order by ID ASC');
	}
	if($rs){
		$url = get_url($rs['ID'],$rs['url_title'],'art');
		$content = str_replace('_title_',$rs['Title'],$str);
		$content = str_replace('_text_',$rs['Title'],$content);
		$content = str_replace('_href_',$url,$content);
	}else{
		$content = str_replace('_title_','',$str);
		$content = str_replace('_text_','',$content);
		$content = str_replace('_href_','#',$content);
	}
	return $content;
}
//搜索列表

//文章列表
function dis_articles_text($list1,$str,$num='200'){
	$pstr = '';
	foreach ($list1 as $val) {
		$href = get_url($val['ID'],$val['url_title'],'art');
		$catid = safe_field('id','txp_category','name=\''.$val['Category1'].'\'');
		$catdir = get_url($catid,$val['Category1'],'cat');
		$cont=safe_cut_str(filter_body($val['Body']),$num,'');
		$padd = str_replace('_title_',$val['Title'],$str);
		$padd = str_replace('_text_',$val['Title'],$padd);
		$padd = str_replace('_href_',$href,$padd);

		$padd = str_replace('_catehref_',$catdir,$padd);
		$padd = str_replace('_catetitle_',$val['Category1'],$padd);
		$padd = str_replace('_con_',$cont,$padd);


		$pstr.=$padd;
	}
	return $pstr;
}
//分类列表显示
function dis_articles_categoriest($list,$str,$num='5'){
	$r = dis_articles_text($list,$str,200);
	return $r;
}
//标签列表显示
function dis_list_tags($list,$str,$num='200'){
	$num = !empty($num)?intval($num):200;
	$r = dis_articles_text($list,$str,$num);
	return $r;

}
//搜索结果显示
function dis_list_search($list,$str,$num='200'){
	$num = !empty($num)?intval($num):200;

}
//分类展示
function dis_categories($str,$showtype='0',$num='0'){
	$showtype = ch_int($showtype);
	$num = ch_int($num);
	$html = '';
	if($num) $limit_str = ' limit '.$num;
	//提取分类列表
	$rows = safe_rows('id,name,parent,title','txp_category',"type='article' and name<>'' and name<>'root' order by id desc".$limit_str);
	foreach($rows as $key=>$val){
		$href = get_url($val['id'],$val['title'],'cat');
		$title = $val['title'];
		$html_str = str_replace('_href_',$href,$str);
		$html_str = str_replace('_title_',$title,$html_str);
		$html_str = str_replace('_text_',$title,$html_str);
		$html.=$html_str;
	}
	return $html;
}
//标签展示
function dis_tags($str,$num='0'){

}
//显示最新X篇文章列表
function dis_random_article($str,$num='10',$pnum='0'){
	$html='';
	$num = ch_int($num);
	if(empty($num)){
		$num=10;
	}
	$rows = safe_rows('ID,Title,url_title','textpattern','`Status`=4 order by ID DESC limit '.$num);
	foreach($rows as $key=>$val){
		$url = get_url($val['ID'],$val['url_title'],'art');
		$content = str_replace('_title_',$val['Title'],$str);
		$content = str_replace('_text_',$val['Title'],$content);
		$content = str_replace('_href_',$url,$content);
		$html.=$content;
	}
	return $html;
}
//关联产品
function dis_article_related($info,$str,$num='10'){
	$html='';
	$num = ch_int($num);
	if(empty($num)){
		$num=10;
	}
	$rows = safe_rows('ID,Title,url_title','textpattern','id<>'.$info['id'].' and Category1=\''.$info['catetitle'].'\' limit '.$num);
	foreach($rows as $key=>$val){
		$url = get_url($val['ID'],$val['url_title'],'art');
		$content = str_replace('_title_',$val['Title'],$str);
		$content = str_replace('_text_',$val['Title'],$content);
		$content = str_replace('_href_',$url,$content);
		$html.=$content;
	}
	return $html;
}


//分页
function dis_pages($str,$pageCount,$num){
	if($pageCount==0) {
		return '<font color="#999">Nothing</font>';
	}elseif($pageCount==1){
		return false;
	}else{
		$thisurl = urldecode($_SERVER['REQUEST_URI']);
		$page = !empty($_REQUEST['pg'])?intval($_REQUEST['pg']):0;
		$page = max($page,1);
		$rangepage = 10;

		$page2 = $page-5;
		if ($page2 < 1) $page2=1;
		$startpage = max($page2,$page-$rangepage+1);
		$endpage   = min($pageCount,$startpage + $rangepage - 1);
		$startpage = min($startpage,$endpage - $rangepage + 1);

		if($startpage < 1) $startpage = 1;

		if(strstr($thisurl,'pg=')){
			$thisurl = substr($thisurl,0,strpos($thisurl,'pg=')); //去掉start和后面的参数
		}
		$thisurl = trim($thisurl,'?');
		$thisurl = trim($thisurl,'&');//先去掉末尾的?和&
		if(strstr($thisurl,'?')){
			//仍然有?的 为有其他参数
			$thisurl=$thisurl.'&';
		}else{
			$thisurl=$thisurl.'?';
		}

		$html = dis_pagesGetHtml($thisurl, 1, '◀◀', $str);
		if ($page > 1){
			$prenum = $page-1;
			$html .= dis_pagesGetHtml($thisurl, $prenum, '◀', $str);
		}

		for($i = $startpage;$i <= $endpage;$i++){
			$html .= dis_pagesGetHtml($thisurl, $i, $i, $str); //下一页
			if($i == $pageCount) break;
		}

		if($page < $pageCount){
			$nextpage = $page+1;
			$html .= dis_pagesGetHtml($thisurl, $nextpage, '▶', $str);//下一页
		}
		if($pageCount>1){
			$html .= dis_pagesGetHtml($thisurl, $pageCount, '▶▶', $str); //跳到尾页
		}
        $html .= $pageCount;
		return $html;
	}
}

//站点地图
function dis_sitemap($str){
	$pstr = str_replace('_href_', '/', $str);
	$pstr = str_replace('_title_', $_SERVER['HTTP_HOST'], $pstr);
	$pstr = str_replace('_text_', $_SERVER['HTTP_HOST'], $pstr);  //首页连接

	$rows = safe_rows('*','txp_category','type=\'article\' and name<>\'root\' and name<>\'\'');
	foreach ($rows as $key => $val) {
		$href = get_url($val['id'], $val['title'],'cat');
		$title = $val['title'];
		$html_str = str_replace('_href_', $href, $str);
		$html_str = str_replace('_title_', $title, $html_str);
		$html_str = str_replace('_text_', $title, $html_str);
		$pstr .= $html_str;
	}

	//获取文章列表链接
	$rows = safe_rows('ID,Title,url_title','textpattern','`Status`=4');
	foreach ($rows as $key => $val) {
		//获取所属分类路径
		$href = get_url($val['ID'], $val['url_title'],'art');
		$title = $val['Title'];
		$html_str = str_replace('_href_', $href, $str);
		$html_str = str_replace('_title_', $title, $html_str);
		$html_str = str_replace('_text_', $title, $html_str);
		$pstr .= $html_str;
	}
	return $pstr;
}
//-----------------------


//底部版权信息
function dis_foot_info(){
	include(txpath."/../templates/".HOST_NAME."/footer.tpl.php");
	return $html;
}
/* 通用功能 */
//强制转INT
function ch_int($num){
	return !empty($num)?intval($num):0;
}

function safe_cut_str($str, $length, $more = '')
{
	$return = '';
	$i = 0;
	$n = 0;
	$len = strlen($str);
	while(($n < $length) && ($i <= $len))
	{
		$tmp = substr($str, $i, 1);
		$asc = ord($tmp);
		if ($asc >= 224)
		{
			$return .= substr($str, $i, 3);
			$i += 3;
			$n++;
		}
		else if ($asc >= 192)
		{
			$return .= substr($str, $i, 2);
			$i += 2;
			$n++;
		}
		else if ($asc >= 65 && $asc <= 90)
		{
			$return .= substr($str, $i, 1);
			++$i;
			++$n;
		}
		else
		{
			$return .= substr($str, $i, 1);
			++$i;
			$n += 0.5;
		}
	}
	if ($len > $length)
	{
		$return .= $more;
	}
	return $return;
}

//标题URL通用字符串过滤
function filter_urlstr($str,$ext=0){
// echo 	"demo11";exit;
    $ext = !empty($ext)?1:0;
    $re_arr = array('【','】','★','?','☆','(',')','（','）','.','：',':','≪','≫','。','，','"','&','『','』','「','」','φ','\'','・','€','●','◆','\\','*','+','#','%','$','^','|','_','[',']','〔','〕', '<', '>');
    $str = str_replace($re_arr,'',$str);
    $str = utf8_unicode($str);
    $str = unicode_decode($str);    //hwz:两次转换用于过滤其他无法识别的字符！
    if($ext){
        $str = filter_blankstr($str);
    }
    return $str;
}

//标题URL通用字符串过滤
function filter_gen($str,$ext=0){
    $ext = !empty($ext)?1:0;
    $re_arr = array(' ','【','】','★','?','☆','(',')','（','）','.','：',':','≪','≫','。','，','"','&','『','』','「','」','φ','\'','・','●','◆','*','+','#','%','$','^','|','_','[',']','〔','〕','ü','-',' ');
    $str = str_replace($re_arr,'',$str);
    $str = utf8_unicode($str);
    $str = unicode_decode($str);    //hwz:两次转换用于过滤其他无法识别的字符！
    if($ext){
        $str = filter_blankstr($str);
    }
    return $str;
}

function filter_blankstr($str){
    $re_str=" |　";  //URL过滤其他字符（如空格），用 | 分割
    $re_arr = explode("|",$re_str);
    $str = str_replace($re_arr,'',$str);
    return $str;
}


//body过滤函数
function filter_body($str){
	$str = preg_replace('/<\/?(td|tr|div|table|tbody|font|script)[^>]*?>/i','',$str); //过滤标签但是保留其中的数据
	return $str;
}

//hwz:过滤内容中的跳转域名{{...}}
function filter_host($str){
    $str = preg_replace("/{{(.+?)}}/", "", $str);
    return $str;
}

//beecky:获取用户IP地址
function ip()
{
	if (isset($_SERVER))
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		elseif (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (isset($_SERVER['HTTP_X_FORWARDED']))
		{
			$ip = $_SERVER['HTTP_X_FORWARDED'];
		}
		elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
		{
			$ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		}
		elseif (isset($_SERVER['HTTP_FORWARDED_FOR']))
		{
			$ip = $_SERVER['HTTP_FORWARDED_FOR'];
		}
		elseif (isset($_SERVER['HTTP_FORWARDED']))
		{
			$ip = $_SERVER['HTTP_FORWARDED'];
		}
		else
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
	}
	else
	{
		if (getenv('HTTP_X_FORWARDED_FOR'))
		{
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_CLIENT_IP'))
		{
			$ip = getenv('HTTP_CLIENT_IP');
		}
		else
		{
			$ip = getenv('REMOTE_ADDR');
		}
	}

	return $ip;

}
//格式化URL $type= cat（分类页）/art（文章内容页）
function get_url($id,$title='',$type=''){
	$type = !empty($type)?$type:'cat';
    if(strstr($title,'.html')){
        //带.html的为已过滤标题的URL
        $title = str_replace('.html','',$title);
    }else{
        $title = filter_urlstr($title);
    }
	switch($type){
		case 'cat':
			$url = $title.'-'.CATE_STR.'-'.$id.'.html';
			break;
		case 'art':
            //文章页
			$url = $title.'-'.ART_STR.'-'.$id.'.html';
			break;
		default:
			$url = $title.'-'.ART_STR.'-'.$id.'.html';
	}
	//var_dump($_SERVER);
	$url = dis_base_url().'/'.$url;
	return $url;
}
//解析URL参数
function sp_url($url=''){
    $url = $f_url = !empty($url)?$url:$_SERVER['REQUEST_URI'];
    //$url = str_replace('.html','',$url);
    if(strstr($url,'.html')){
        $f_url = substr($url,0,strpos($url,'.html')); //去掉.html后面的内容
    }
    $url_str = trim($f_url,'/');
    $r['url'] = $url;
    if(strstr($url_str,'-')){
        $url_arr = explode('-',$url_str);
        if(count($url_arr)>=3){
            $r['id']=$url_arr[count($url_arr)-1];
            $r['typename']=$url_arr[count($url_arr)-2];
            //$r['title']=urldecode(str_replace(array('-'.$r['id'],'-'.$r['typename']),'',$url_str));
        }
    }
    return $r;
}

//函数格式化输出函数 -- kevin 2015.10.17
function dis_pagesGetHtml($url, $pg, $symbol, $format){
	$html=str_replace('_href_', $url.'pg='.$pg, $format);
	$html=str_replace('_title_', $pg, $html);
	$html=str_replace('_text_', $symbol, $html);
	return  $html;
}
/**
 * utf-8 转unicode
 *
 * @param string $name
 * @return string
 */
function utf8_unicode($name){
    $name = iconv('UTF-8', 'UCS-2', $name);
    $len  = strlen($name);
    $str  = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2){
        $c  = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0){   //两个字节的文字
            $str .= '\u'.base_convert(ord($c), 10, 16).str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
            //$str .= base_convert(ord($c), 10, 16).str_pad(base_convert(ord($c2), 10, 16), 2, 0, STR_PAD_LEFT);
        } else {
            $str .= '\u'.str_pad(base_convert(ord($c2), 10, 16), 4, 0, STR_PAD_LEFT);
            //$str .= str_pad(base_convert(ord($c2), 10, 16), 4, 0, STR_PAD_LEFT);
        }
    }
    $str = strtoupper($str);//转换为大写
    return $str;
}

/**
 * unicode 转 utf-8
 *
 * @param string $name
 * @return string
 */
function unicode_decode($name)
{
    $name = strtolower($name);
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}