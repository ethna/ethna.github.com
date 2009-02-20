<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta name="robots" content="INDEX,FOLLOW" />

<meta name="keywords" content="" />
<meta name="description" content="" />

<link rel="stylesheet" href="{$config.url}css/style.css" type="text/css" />
<!-- additinal header
<script type="text/javascript" src="/js/script.js"></script>

<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="/rss" />

<link rel="stylesheet" href="/css/style.css" type="text/css" media="all" />
<link rel="stylesheet" href="/css/print.css" type="text/css" media="print" />
-->


<title>book.ethna.jp</title>
</head>
<body>
<div id="frame">
<div id="container">

<div id="header">
 <h1><a href="{{$config.url}}">book.ethna.jp</a></h1>

 <ul>
  <li><a href="http://ethna.jp/">top</a></li>
  <li><a href="{{$config.url}}">book</a></li>
 </ul>
</div>

<div id="main">

{{$content}}
    
</div>

<div id="footer">
 <p>Copyright &copy; 2009 , All Rights Reserved.</p>
    <p>
    Powered By <a href="http://ethna.jp">Ethna</a>-{{$smarty.const.ETHNA_VERSION}}.
    </p>
</div>

</div>
</div>

</body>
</html>

