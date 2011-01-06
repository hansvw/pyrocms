<?php
function _render_nav($link_list, $level=0)
{
	if($level == 0)
	{
		echo '<ul class="art-menu">';
		_render_nav($link_list, $level + 1);
		echo '</ul>';
	}
	else
	{
		foreach($link_list as $link)
		{
			$linkclass = '';
			
		/// Treat link to 'home' differenty
			if($link->url == site_url())
			{
				if(current_url() == $link->url)
				{
					$linkclass = ' class="active"';
				}
			}
			else
			{
				if(current_url() == $link->url)
				{
					$linkclass = ' class="active"';
				}

				if(strlen($link->url) < strlen(current_url()))
				{
					$comparison = substr_compare(current_url(),$link->url,0,strlen($link->url));
				
					if($comparison == 0)
					{
						$linkclass = ' class="active"';
					}
				}
			}
			
			if(null != $link->target && $link->target != '')
			{
				echo '<li><a href="'.$link->url.'"'.$linkclass.' target="'.$link->target.'">';
			}
			else
			{
				echo '<li><a href="'.$link->url.'"'.$linkclass.'>';
			}
			echo '<span class="l"></span><span class="r"></span><span class="t">'.$link->title.'</span></a>';
			if(!empty($link->children))
			{
				echo '<ul>';
				_render_nav($link->children, $level + 1);
				echo '</ul>';
			}
			echo '</li>';
		}
	}
}

_render_nav(navigation_tree($group));

/**
<ul class="<?php echo ($level > 0 ? 'navigation-level-'.$level : 'navigation'); ?>">
	<?php foreach( $link_list as $link): ?>
		<li<?php echo (current_url() == $link->url ? ' class="current"' : ''); ?>><?php echo anchor($link->url, $link->title, 'target="'.$link->target.'"');
		if(!empty($link->children))
		{
			_render_nav($link->children, $level+1);
		}
?>
</li>
	<?php endforeach; ?>
</ul>
*/
