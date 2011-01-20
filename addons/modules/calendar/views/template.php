<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$header;?></title>
<base href="<?=base_url();?>" />
<link rel="stylesheet" href="<?= base_url();?>css/master.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?= base_url();?>css/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script src="<?= base_url();?>js/coda.js" type="text/javascript"> </script>

</head>
<body>
<div id="container">

<div id="logo"><a href="index.html"><img src="img/logo.png" width="172" height="58" alt="logo" /></a></div>
<div id="navcontainer">
<ul>
<li><?php echo anchor('calendar/create', 'Add Events to Calendar');?> </li>
<li><?php echo anchor('calendar/index/', 'Show Site Calendar');?></li>

</ul>
</div>
<div id="header">
<?php $this->load->view($main);?>

  </div>
  
 


<div id="left">
<h2>Events Calendar</h2>
<p>Calendar on Codeigniter. You can use this with javascript unabled. lobortis erat. Cras non nibh mauris. Curabitur sed dolor eu urna lobortis malesuada a ac tellus. Cras at est turpis. Morbi tempor erat ut augue venenatis cursus. Nullam ullamcorper congue velit, ut suscipit eros sodales id. Proin ante orci, dictum nec pulvinar non, mollis at est. Duis ultrices aliquet tincidunt. Donec eu libero arcu, non aliquet orci. Curabitur lacinia leo non enim laoreet pellentesque.</p>
</div>

<div id="right">
<h2>Codeigniter</h2>
<p>Nullam ac lobortis erat. Cras non nibh mauris. Curabitur sed dolor eu urna lobortis malesuada a ac tellus. Cras at est turpis. Morbi tempor erat ut augue venenatis cursus. Nullam ullamcorper congue velit, ut suscipit eros sodales id. Proin ante orci, dictum nec pulvinar non, mollis at est. Duis ultrices aliquet tincidunt. Donec eu libero arcu, non aliquet orci. Curabitur lacinia leo non enim laoreet pellentesque.</p>
</div>

<div id="middle">
<h2>Okada Design AS</h2>
<p>Nullam ac lobortis erat. Cras non nibh mauris. Curabitur sed dolor eu urna lobortis malesuada a ac tellus. Cras at est turpis. Morbi tempor erat ut augue venenatis cursus. Nullam ullamcorper congue velit, ut suscipit eros sodales id. Proin ante orci, dictum nec pulvinar non, mollis at est. Duis ultrices aliquet tincidunt. Donec eu libero arcu, non aliquet orci. Curabitur lacinia leo non enim laoreet pellentesque.</p>
</div>



<div id="footer">&copy; My Company &bull; Telephone: 99 99 99 99 &bull; My address goes here <br />Template by: <a href="http://www.csstemplateheaven.com">CssTemplateHeaven</a></div>

</div><!-- close container -->

</body>
</html>



