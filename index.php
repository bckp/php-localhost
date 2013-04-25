<?php
/**
 * localhostView
 *
 * Copyright (c) 2007, 2012 Radovan Kepak (http://www.kepak.eu)
 * @license MIT
 */

 //Czech language
 $lang_cs = array(
  'other' =>  'Ostatní',

  '_modules'   => 'Moduly',
  '_extension'   => 'Rozšíření',
  '_setting'   => 'Nastavení',
  '_activated'  =>  'Aktivní'
 );

 //English language
 $lang_en = array(
  'other' =>  'Other',
  '_modules'  =>  'Modules',
  '_extension'  =>  'Extensions',
  '_setting'  =>  'Settings',
  '_activated'  =>  'Activated',
 );

 //System setup
 $lang = &$lang_en;

 //What setting we should get by ini_get
 $setting = array('short_open_tag', 'disable_functions', 'memory_limit', 'register_globals', 'open_basedir', 'upload_max_filesize' );

 //Some variables
 $server = getenv( 'SERVER_NAME' );
 $data = array();

 //Load data structure
 $handle = opendir( getcwd() );
 $default = 'other';
 $prefixSeparator = '-';

 //Load directory structure, if in directory is file .ignore, we will ignore that directory ( like android with .nomedia )
 while( false !== ($file = readdir($handle)) ){
  if( substr( $file, 0, 1 ) == '.' || !is_dir($file) || file_exists($file . '/.ignore') ) continue;

  $prefix = ( ($p = strpos($file, $prefixSeparator)) ? substr($file, 0, $p) : $default );

  if(!isset($data[$prefix]))
    $data[$prefix] = array();

  $data[$prefix][] = $file;
 }
 closedir($handle);

 foreach($data as $key => $item){
    if($key == $default)
      continue;

    if(count($item) == 1){
      $data[$default][] = reset($item);
      unset($data[$key]);
    }
 }

 asort($data);

 function __($a){
  if(isset($GLOBALS['lang'][$a]))
    return $GLOBALS['lang'][$a];
  return $a;
 }

 function i($a){
  $a = trim( var_export(ini_get($a), true), '\'' );
  echo ( $a ? $a : 'null' );
 }

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title><?php echo __($server); ?></title>

		<style type="text/css">
			/* RESET | http://meyerweb.com/eric/tools/css/reset/ | v2.0 | 20110126 | License: none (public domain) */
			html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin: 0;padding: 0;border: 0;font-size: 100%;font: inherit;vertical-align: baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display: block}body{line-height: 1}ol,ul{list-style: none}blockquote,q{quotes: none}blockquote:before,blockquote:after,q:before,q:after{content: '';content: none}table{border-collapse: collapse;border-spacing: 0}

			/* Localhost style */
      body,html{background: white;font-family: 'Segoe UI', Tahoma, sans-serif;font-size: 85%}h1,h2,h3{font-weight: normal;line-height: 1;padding: 21px 0px 1em;margin: 0px 23px 1px}h1{color: #5C6166;font-size: 1.5em}h2{border-bottom: 1px #eee solid;color: #5C6166;font-size: 1.5em;margin: 0px 0px 13px;padding-bottom: 10px}li,h1,h2{text-transform: lowercase}li:first-letter,h1:first-letter,h2:first-letter{text-transform: uppercase}.clr{clear:both}#left{width: 160px;position: absolute;top: 0px;left: 0px;height: 100%;background: white}#left ul{list-style-type: none;padding: 0;color: #999;font-size: 1.1em;margin-bottom: 40px}#left li{padding: 3px 15px;margin: 3px 0px 3px 8px;cursor: pointer}#left li.active{border-left: 8px #464E5A solid;padding: 3px 15px;margin: 3px 0px;color: #464E5A}#content{margin: 0px 20px 0px 180px}#content a,#content b,#content span{box-sizing:border-box;display:block;color:#999;padding:5px;margin:3px 0;font-size:1.1em;text-decoration:none;border-radius:3px;transition: all .2s;}#content b{float:left;width:25%;text-transform:lowercase}#content a:nth-child(odd),#content span:nth-child(odd){background: #eee}#content a:hover{color:#111}#content span i{float: right}
		</style>
		<script type="text/javascript">
      var tabs={init:function(elm){this.elms=this.getChild(this.gId(elm).children);this.hide();var e=document.getElementsByTagName('li')[0];this.activate(e.innerHTML.toLowerCase(),e);},hide:function(){for(i in this.elms)this.elms[i].style['display']='none';var a=this.gCn('active');for(i in a)a[i].className='';},gCn:function(a){return document.getElementsByClassName(a);},gId:function(a){return document.getElementById(a);},getChild:function(a){var ret=new Array();for(i=0;i<a.length;i++)ret[i]=a[i];return ret;},activate:function(a,b){this.hide();b.className='active';this.gId(a).style['display']='block';},elms:new Array()};window.onload=function(){tabs.init('content');};
		</script>
</head>
<body>
	<div id="left">
		<h1><?php echo __($server); ?></h1>
		<ul>
			<?php foreach($data as $key => $item): ?>
			<li onclick="tabs.activate('<?php echo $key; ?>', this);"><?php echo __($key); ?></li>
			<?php endforeach; ?>
		</ul>
    <ul>
      <li onclick="tabs.activate('_modules', this)"><?php echo __('_modules'); ?></li>
      <li onclick="tabs.activate('_extension', this)"><?php echo __('_extension'); ?></li>
      <li onclick="tabs.activate('_setting', this)"><?php echo __('_setting'); ?></li>
    </ul>
	</div>
	<div id="content">
		<?php foreach($data as $key => $item): ?>
			<div id="<?php echo $key; ?>">
				<h2><?php echo __($key); ?></h2>
				<?php foreach($item as $project): ?>
					<a href="/<?php echo $project ?>/"><?php echo $project; ?></a>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>
    <div id="_modules">
      <h2><?php echo __('_activated') . '&nbsp;' . __('_modules'); ?></h2>
      <?php foreach( apache_get_modules() as $item ): ?>
        <b><?php echo $item; ?></b>
      <?php endforeach; ?>
      <br class="clr"/>
    </div>
    <div id="_extension">
      <h2><?php echo __('_activated') . '&nbsp;' . __('_extension'); ?></h2>
      <?php foreach( get_loaded_extensions() as $item ): ?>
        <b><?php echo $item; ?></b>
      <?php endforeach; ?>
      <br class="clr"/>
    </div>
    <div id="_setting">
      <h2><?php echo __('_activated') . '&nbsp;' . __('_setting'); ?></h2>
      <?php foreach( $setting as $item ): ?>
        <span><?php echo $item; ?><i><?php echo i($item);?></i></span>
      <?php endforeach; ?>
      <span><?php echo __('php_version'); ?><i><?php echo PHP_VERSION; ?></i></span>
      <span><?php echo __('apache_token'); ?><i><?php echo apache_get_version(); ?></i></span>
    </div>
	</div>
</body>
</html>