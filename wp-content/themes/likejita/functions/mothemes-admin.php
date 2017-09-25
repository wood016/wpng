<?php

add_action('admin_menu', 'mothemes_admin_menu');
function mothemes_admin_menu() {
	add_menu_page(__( 'theme option', 'MoThemes' ), __( 'theme option', 'MoThemes' ), 'edit_themes', basename(__FILE__), 'mothemes_settings_page');
	add_action( 'admin_init', 'mothemes_settings' );
}

add_action('admin_init', 'mothemes_page_init');
function mothemes_page_init(){
	if (isset($_GET['page']) && $_GET['page'] == 'mothemes-admin.php') {
		//error_reporting(0);
		ob_start();
		ob_end_clean();
		$dir = get_bloginfo('template_directory');
		$ajax_url = home_url("/").'?ajax_src=';
		wp_enqueue_style('admincss', $dir . '/styles/admin.css', false, '1.0.0', false);
		echo "<script type='text/javascript'>var ajax_url = \"$ajax_url\"; </script>";
		wp_enqueue_script('adminjs', $dir . '/scripts/admin.js', false, '1.0.0', false);
	}
}

function mothemes_settings() {
	register_setting( 'mothemes-settings-group', 'mothemes_options' );
}

function mothemes_settings_page() {
	if ( isset($_REQUEST['settings-updated']) ) echo '<div id="message" class="updated fade"><p><strong>保存成功！</strong></p></div>';
	if( 'reset' == isset($_REQUEST['reset']) ) {
		delete_option('mothemes_options');
		echo '<div id="message" class="updated fade"><p><strong>重置成功！</strong></p></div>';
	}
?>
<html xmlns:wb="http://open.weibo.com/wb">
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br></div><h2><?php _e( 'theme option', 'MoThemes' );?></h2><br>
		<form method="post" action="options.php">
			<?php settings_fields( 'mothemes-settings-group' ); ?>
			<?php $options = get_option('mothemes_options'); ?>
			<div id="set-nav">
				<ul>
					<li><a  class="current" href="#"><?php _e( 'Basic Settings', 'MoThemes' );?></a></li>
					<li><a href="#"><?php _e( 'HomePage Settings', 'MoThemes' );?></a></li>
					<li><a href="#"><?php _e( 'Appearances Settings', 'MoThemes' );?></a></li>
					<li><a href="#"><?php _e( 'Filmstrip Settings', 'MoThemes' );?></a></li>
					<li><a href="#"><?php _e( 'Advertisement Settings', 'MoThemes' );?></a></li>
					<li><a href="#"><?php _e( 'Function Settings', 'MoThemes' );?></a></li>
					<li><a href="#"><?php _e( 'Sns Settings', 'MoThemes' );?></a></li>
					<li><a href="#"><?php _e( '主题说明', 'MoThemes' );?></a></li>
				</ul>
			</div>
			<div id="set-cont" class="clx">
				<ul>
					<li class="current">
						<div class="item item-1 clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[sitebbs]">网站公告</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[sitebbs]"><?php echo $options['sitebbs']; ?></textarea></div>
							<div class="span span3"><small class="set-small">用简洁凝练的话描述你的网站公告</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[description]">网站描述</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[description]"><?php echo $options['description']; ?></textarea></div>
							<div class="span span3"><small class="set-small">用简洁凝练的话对你的网站进行描述</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[keywords]">网站关键词</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[keywords]"><?php echo $options['keywords']; ?></textarea></div>
							<div class="span span3"><small class="set-small">多个关键词请用英文逗号隔开</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[head-analysis]">网站统计(页眉)</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[head-analysis]"><?php echo $options['head-analysis']; ?></textarea></div>
							<div class="span span3"><small class="set-small">输入统计代码</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[analysis]">网站统计(页脚)</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[analysis]"><?php echo $options['analysis']; ?></textarea></div>
							<div class="span span3"><small class="set-small">输入统计代码</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[sharecode]">网站内页分享代码</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[sharecode]"><?php echo $options['sharecode']; ?></textarea></div>
							<div class="span span3"><small class="set-small">网站内页分享代码,请使用单行显示模式的代码。</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[indexshare]">网站首页分享代码</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[indexshare]"><?php echo $options['indexshare']; ?></textarea></div>
							<div class="span span3"><small class="set-small">网站首页分享代码,请使用单行显示模式的代码。</small></div>
						</div>
					</li>
					<li>
						<div class="item clx">
							<div class="span span1"><label class="set-label">所有分类信息</label></div>
							<?php $args=array('orderby' => 'term_id','order' => 'ASC');
								$categories=get_categories($args);
								foreach($categories as $category) {$theme_all_cata .= '<span id="catali">[ID:'.$category->term_id.'] -> '. $category->name.'</span>  ' ;}
							?>
							<div class="span span_cata"><label class="set-label"><?php echo $theme_all_cata; ?> </label></div>
					  </div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[homezone_cata_ids]">首页分类显示设定</label></div>
							<div class="span span2"><input type="text" class="set-input" name="mothemes_options[homezone_cata_ids]" value="<?php echo $options['homezone_cata_ids']; ?>" /></div>
							<div class="span span3"><small class="set-small">直接输入在首面中显示的分类ID，英文逗号隔开（仅在首页显示）</small></div>
						</div>
						<div class="item item-1 clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[homezone_cata_displaynum]">首页分类显示数量</label></div>
							<div class="span span2"><input type="text" class="set-input" name="mothemes_options[homezone_cata_displaynum]" value="<?php echo $options['homezone_cata_displaynum']; ?>" /></div>
							<div class="span span3"><small class="set-small">默认设定为5个，不建议调整。</small></div>
						</div>
						<!--设定新片速递参数-->
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[homenews_cata_ids]">新片速递显示分类</label></div>
							<div class="span span2"><input type="text" class="set-input" name="mothemes_options[homenews_cata_ids]" value="<?php echo $options['homenews_cata_ids']; ?>" /></div>
							<div class="span span3"><small class="set-small">直接输入在首页中显示的分类ID，英文逗号隔开（仅在首页显示）</small></div>
						</div>
						<div class="item item-1 clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[homezone_cata_displaynum]">速递显示数量</label></div>
							<div class="span span2"><input type="text" class="set-input" name="mothemes_options[homenews_cata_displaynum]" value="<?php echo $options['homenews_cata_displaynum']; ?>" /></div>
							<div class="span span3"><small class="set-small">默认设定为5个，不建议调整。</small></div>
						</div>
						<!--设定新片速递参数-->
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[single_defaultvideo]">默认视频地址</label></div>
							<div class="span span2"><input type="text" class="set-input" name="mothemes_options[single_defaultvideo]" value="<?php echo $options['single_defaultvideo']; ?>" /></div>
							<div class="span span3"><small class="set-small">直接输入内容页默认播放的视频地址。</small></div>
						</div>
						<!--设定新片速递参数-->
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[footer_colcat_2]">首页页脚2栏显示分类</label></div>
							<div class="span span2"><input type="text" class="set-input" name="mothemes_options[footer_colcat_2]" value="<?php echo $options['footer_colcat_2']; ?>" /></div>
							<div class="span span3"><small class="set-small">直接输入在首页页脚2栏显示分类中显示的分类ID（仅在首页显示）</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[footer_colcat_3]">首页页脚3栏显示分类</label></div>
							<div class="span span2"><input type="text" class="set-input" name="mothemes_options[footer_colcat_3]" value="<?php echo $options['footer_colcat_3']; ?>" /></div>
							<div class="span span3"><small class="set-small">直接输入在首页页脚3栏显示分类中显示的分类ID（仅在首页显示）</small></div>
						</div>
					</li>
					<li>
						<div class="item item-1 clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[favicon]">自定义Favicon图标</label></div>
							<div class="span span2">
								<input type="text" class="set-favicon set-input" name="mothemes_options[favicon]" value="<?php echo $options['favicon']; ?>" placeholder="Favicon图标地址" /><a href="#" class="button">上传Favicon图标</a>
							</div>
							<div class="span span3 span-preview"><img src="<?php echo $options['favicon']; ?>" alt="" /></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[logo]">自定义Logo图片</label></div>
							<div class="span span2">
								<input type="text" class="set-logo set-input" name="mothemes_options[logo]" value="<?php echo $options['logo']; ?>" placeholder="Logo图片地址" /><a href="#" class="button">上传Logo图片</a>
							</div>
							<div class="span span3 span-preview"><img src="<?php echo $options['logo']; ?>" alt="" /></div>
						</div>
					</li>
					<li>
						<?php /*$timthumb = get_bloginfo('template_url').'/timthumb.php';*/?>
						<div class="item item-1 clx">
							<div class="span span1"><label class="set-label">设置说明</label></div>
							<div class="span span2">
								<p><strong>提示1:</strong> 图片大小为固定的1440 * 390px</p>
								<p><strong>提示2:</strong> 图片地址必须上传, 如果没有, 即便填写了标题和链接也不会在前台显示</p>
							</div>
						</div>
						<?php $cata = 0; while ($cata < 6) : ?>
						<div class="item clx">
							<div class="span span1"><label class="set-label">分类【<?php echo $cata; ?>】设定</label></div>
							<div class="span span2">
								<input type="text" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][title]" value="<?php echo $options['homecatalist'][$cata]['title']; ?>" placeholder="分类名称" /> 分类名称
								<input type="text" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][href]" value="<?php echo $options['homecatalist'][$cata]['href']; ?>" placeholder="分类链接地址" /> 分类链接地址
								<textarea type="textarea" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][zyjl]"><?php echo $options['homecatalist'][$cata]['zyjl']; ?></textarea> 说明1
								<textarea type="textarea" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][shbz]"><?php echo $options['homecatalist'][$cata]['shbz']; ?></textarea> 说明2
								<input type="text" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][img]" value="<?php echo $options['homecatalist'][$cata]['img']; ?>" placeholder="分类图片地址" /><a href="#" class="button">上传图片</a>
							</div>
							<div class="span span3">
								<?php if(($src0 = $options['homecatalist'][$cata]['img'] )) echo '<img src="'.$src0.'" width=100 height=100 alt="" />';?>
							</div>
						</div>
						<?php $num = 0; while ($num < 5) : ?>
						<div class="item clx">
							<div class="span span1"><label class="set-label">分类【<?php echo $cata; ?>】【<?php echo $num; ?>】设定</label></div>
							<div class="span span2">
								<input type="text" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][catalist][<?php echo $num; ?>][name]" value="<?php echo $options['homecatalist'][$cata]['catalist'][$num]['name']; ?>" placeholder="子项名称" /> 子项名称
								<input type="text" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][catalist][<?php echo $num; ?>][fullname]" value="<?php echo $options['homecatalist'][$cata]['catalist'][$num]['fullname']; ?>" placeholder="子项全名" /> 子项全名
								<input type="text" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][catalist][<?php echo $num; ?>][size]" value="<?php echo $options['homecatalist'][$cata]['catalist'][$num]['size']; ?>" placeholder="子项尺寸型号" /> 子项尺寸型号
								<input type="text" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][catalist][<?php echo $num; ?>][href]" value="<?php echo $options['homecatalist'][$cata]['catalist'][$num]['href']; ?>" placeholder="子项链接地址" /> 子项链接地址
								<input type="text" class="set-thumb set-input" name="mothemes_options[homecatalist][<?php echo $cata; ?>][catalist][<?php echo $num; ?>][img]" value="<?php echo $options['homecatalist'][$cata]['catalist'][$num]['img']; ?>" placeholder="子项图片地址" /><a href="#" class="button">上传图片</a>
							</div>
							<div class="span span3">
								<?php if(($src0 = $options['homecatalist'][$cata]['catalist'][$num]['img'] )) echo '<img src="'.$src0.'" width=175 height=175 alt="" />';?>
							</div>
						</div>
						<?php $num++ ; endwhile; ?>
						<?php $cata++ ; endwhile; ?>
					</li>
					<li>
						<div class="item item-1 clx">
							<div class="span span1"><label class="set-label">广告设置</label></div>
							<div class="span span2"><p><strong>提示:</strong>删除了首页广告设置, 首页广告可以在幻灯片处设置</p></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[admain]">菜单栏上横幅广告</br>(640x60)</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[admain]"><?php echo $options['admain']; ?></textarea></div>
							<div class="span span3"><small class="set-small">输入广告代码，不填写则不显示</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[admenubottom]">菜单栏下横幅广告</br>(960x90)</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[admenubottom]"><?php echo $options['admenubottom']; ?></textarea></div>
							<div class="span span3"><small class="set-small">输入广告代码，不填写则不显示</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[adindexbanner]">首页横幅广告</br>(960x90)</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[adindexbanner]"><?php echo $options['adindexbanner']; ?></textarea></div>
							<div class="span span3"><small class="set-small">输入广告代码，不填写则不显示</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[adindexbanner]">首页竖条广告</br>(160x600)</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[adindexvertical]"><?php echo $options['adindexvertical']; ?></textarea></div>
							<div class="span span3"><small class="set-small">输入广告代码，不填写则不显示</small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label">精彩专题1</label></div>
							<div class="span span2">
								
								<input type="text" class="set-thumb set-input" name="mothemes_options[filmstrip_zhuanti][title][0]" value="<?php echo $options['filmstrip_zhuanti']['title'][0]; ?>" placeholder="图片标题" /> 标题
								<input type="text" class="set-thumb set-input" name="mothemes_options[filmstrip_zhuanti][href][0]" value="<?php echo $options['filmstrip_zhuanti']['href'][0]; ?>" placeholder="链接地址" /> 链接
								<input type="text" class="set-thumb set-input" name="mothemes_options[filmstrip_zhuanti][src][0]" value="<?php echo $options['filmstrip_zhuanti']['src'][0]; ?>" placeholder="图片地址" /><a href="#" class="button">上传图片</a>
							</div>
							<div class="span span3">
								<?php if(($src0 = $options['filmstrip_zhuanti']['src'][0] )) echo '<img src="'.mothemes_thumb($src0, 200, 87, 1).'" alt="" />';?>
							</div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label">精彩专题2</label></div>
							<div class="span span2">
								
								<input type="text" class="set-thumb set-input" name="mothemes_options[filmstrip_zhuanti][title][1]" value="<?php echo $options['filmstrip_zhuanti']['title'][1]; ?>" placeholder="图片标题" /> 标题
								<input type="text" class="set-thumb set-input" name="mothemes_options[filmstrip_zhuanti][href][1]" value="<?php echo $options['filmstrip_zhuanti']['href'][1]; ?>" placeholder="链接地址" /> 链接
								<input type="text" class="set-thumb set-input" name="mothemes_options[filmstrip_zhuanti][src][1]" value="<?php echo $options['filmstrip_zhuanti']['src'][1]; ?>" placeholder="图片地址" /><a href="#" class="button">上传图片</a>
							</div>
							<div class="span span3">
								<?php if(($src0 = $options['filmstrip_zhuanti']['src'][1] )) echo '<img src="'.mothemes_thumb($src0, 200, 87, 1).'" alt="" />';?>
							</div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label">精彩专题3</label></div>
							<div class="span span2">
								
								<input type="text" class="set-thumb set-input" name="mothemes_options[filmstrip_zhuanti][title][2]" value="<?php echo $options['filmstrip_zhuanti']['title'][2]; ?>" placeholder="图片标题" /> 标题
								<input type="text" class="set-thumb set-input" name="mothemes_options[filmstrip_zhuanti][href][2]" value="<?php echo $options['filmstrip_zhuanti']['href'][2]; ?>" placeholder="链接地址" /> 链接
								<input type="text" class="set-thumb set-input" name="mothemes_options[filmstrip_zhuanti][src][2]" value="<?php echo $options['filmstrip_zhuanti']['src'][2]; ?>" placeholder="图片地址" /><a href="#" class="button">上传图片</a>
							</div>
							<div class="span span3">
								<?php if(($src0 = $options['filmstrip_zhuanti']['src'][2] )) echo '<img src="'.mothemes_thumb($src0, 200, 87, 1).'" alt="" />';?>
							</div>
						</div>
						
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[adbrief]">文章页介绍栏广告</br>(300x250)</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[adbrief]"><?php echo $options['adbrief']; ?></textarea></div>
							<div class="span span3"><small class="set-small">输入广告代码，不填写则不显示</small></div>
						</div>
						<div class="item clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[adcomment]">文章页评论栏广告</br>（120x300）</label></div>
								<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[adcomment]"><?php echo $options['adcomment']; ?></textarea></div>
								<div class="span span3"><small class="set-small">输入广告代码，不填写则不显示</small></div>
						</div>
						<div class="item clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[adcontent]">文章页简介上方广告</br>（960x60）</label></div>
								<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[adcontent]"><?php echo $options['adcontent']; ?></textarea></div>
								<div class="span span3"><small class="set-small">输入广告代码，不填写则不显示</small></div>
						</div>
					</li>
					<li>
						<div class="item item-1 clx">
							<div class="span span1"><label class="set-label">jQuery库选择</label></div>
							<div class="span span2">
								<p class="set-p"><input type="radio" id="jQuery" name="mothemes_options[jQuery]" value="1" <?php if($options['jQuery']==1) echo 'checked="checked"'; ?>/><label for="jQuery">调用Jquery官方库</label></p>
								<p class="set-p"><input type="radio" id="msdn" name="mothemes_options[jQuery]" value="2" <?php if($options['jQuery']==2) echo 'checked="checked"'; ?>/><label for="msdn">调用微软msdn-jQuery库</label></p>
								<p class="set-p"><input type="radio" id="sina" name="mothemes_options[jQuery]" value="3" <?php if($options['jQuery']==3) echo 'checked="checked"'; ?>/><label for="sina">调用新浪在线jQuery库</label></p>
								<p class="set-p"><input type="radio" id="self" name="mothemes_options[jQuery]" value="0" <?php if($options['jQuery']==0 || $options['jQuery']=="") echo 'checked="checked"'; ?>/><label for="self">调用主题自带</label></p>
							</div>
							<div class="span span3 span3-jquery"><small class="set-small"><p class="set-p">1.jQuery官方提供;</p><p class="set-p">2.Microsoft CDN提供;</p><p class="set-p">3.新浪SAE提供;</p><p class="set-p">4.默认选择主题自带</p></small></div>
						</div>
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[postid]">缩略图重命名</label></div>
							<div class="span span2 span2-notes"><input id="postid" type="checkbox" name="mothemes_options[postid]" value="1" <?php if($options['postid']) echo 'checked="checked"'; ?>/><label for="postid">开启 缩略图重命名 功能</label></div>
							<div class="span span3"><small class="set-small">选中后 图片前会有文章id来防止重复</small></div>
						</div>						
						<div class="item clx">
							<div class="span span1"><label class="set-label" for="mothemes_options[footer]">底部版权</label></div>
							<div class="span span2"><textarea type="textarea" class="set-textaera" name="mothemes_options[footer]"><?php echo $options['footer']; ?></textarea>
							<p><strong>底部预览:</strong><br/><?php $options = get_option('mothemes_options');
							if( $options['footer']){?>
								<?php echo $options['footer'];?>
							<?php }else{?>
								<p>&copy; <?php echo date("Y");?> <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> <?php _e('All Rights Reserved！','MoThemes');?></p>
							<?php }?></p>
							</div>
							<div class="span span3"><small class="set-small">底部版权不填写,则不修改</small></div>
						</div>						
					</li>
					<li>
						<div class="item item-1 ">
						    <div class="set-sns clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[index_tsina]">新浪微博关注按钮</label></div>
								<div class="span span2"><input type="text" class="set-input" name="mothemes_options[index_tsina]" value="<?php echo $options['index_tsina']; ?>" /></div>
								<div class="span span3"><small class="set-small">直接输入微博uid，最多支持3个，英文逗号隔开（仅在首页显示）</small></div>
							</div><div class="set-gap"></div>
							<div class="set-sns clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[rss]">RSS</label></div>
								<div class="span span2"><input type="text" class="set-input" name="mothemes_options[rss]" value="<?php echo $options['rss']; ?>" /></div>
								<div class="span span3"><small class="set-small">RSS地址，不填写则使用Wordpress自带的rss地址</small></div>
							</div><div class="set-gap"></div>
							<div class="set-sns clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[wechat]">微信二维码</label></div>
								<div class="span span2"><input type="text" class="set-input" name="mothemes_options[wechat]" value="<?php echo $options['wechat']; ?>" /></div>
								<div class="span span3"><small class="set-small">微信二维码</small></div>
							</div><div class="set-gap"></div>
							<div class="set-sns clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[tsina]">新浪微博</label></div>
								<div class="span span2"><input type="text" class="set-input" name="mothemes_options[tsina]" value="<?php echo $options['tsina']; ?>" /></div>
								<div class="span span3"><small class="set-small">新浪微博个人页面</small></div>
							</div><div class="set-gap"></div>
							<div class="set-sns clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[tqq]">腾讯微博</label></div>
								<div class="span span2"><input type="text" class="set-input" name="mothemes_options[tqq]" value="<?php echo $options['tqq']; ?>" /></div>
								<div class="span span3"><small class="set-small">腾讯微博个人页面</small></div>
							</div><div class="set-gap"></div>
							<div class="set-sns clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[renren]">人人网</label></div>
								<div class="span span2"><input type="text" class="set-input" name="mothemes_options[renren]" value="<?php echo $options['renren']; ?>" /></div>
								<div class="span span3"><small class="set-small">人人网个人页面</small></div>
							</div><div class="set-gap"></div>
							<div class="set-sns clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[douban]">豆瓣网</label></div>
								<div class="span span2"><input type="text" class="set-input" name="mothemes_options[douban]" value="<?php echo $options['douban']; ?>" /></div>
								<div class="span span3"><small class="set-small">豆瓣网个人页面</small></div>
							</div><div class="set-gap"></div>
							<div class="set-sns clx">
								<div class="span span1"><label class="set-label" for="mothemes_options[kaixin]">开心网</label></div>
								<div class="span span2"><input type="text" class="set-input" name="mothemes_options[kaixin]" value="<?php echo $options['kaixin']; ?>" /></div>
								<div class="span span3"><small class="set-small">开心网个人页面</small></div>
							</div>
						</div>						
					</li>
					<li>
					<div class="mothemes_option_wrap">
						<div class="mothemes_option_section">
							<h2><?php _e('主题说明','mothemes') ?></h2>
						</div>
						<div class="mothemes_helppage">
							<p>当前主题：<?php $theme_data = get_theme_data(get_bloginfo('template_directory') . '/style.css');echo $theme_data['Title']; ?></p>
							<p>主题版本：<?php echo $theme_data['Version']; ?></p>
							<p>主题作者：<?php echo $theme_data['Version']; ?></p>
						</div>
					</div>
					</li>
				</ul>
			</div>
			<div class="mothemes_submit_form">
				<input type="submit" class="button-primary mothemes_submit_form_btn" name="save" value="<?php _e('Save Changes') ?>"/>
			</div>
		</form>
	<form method="post">
		<div class="mothemes_reset_form">
			<input type="submit" name="reset" value="<?php _e( 'Reset', 'MoThemes' );?>" class="button-secondary mothemes_reset_form_btn"/> 重置有风险，操作需谨慎！
			<input type="hidden" name="reset" value="reset" />
		</div>
	</form>
	</div>
	<?php wp_enqueue_media();?>
<?php } ?>