<?php
/**
 *
 */

$hoge = <<<HOGE
#<div id="page_action" class="bar"><!-- \?\?BEGIN id:page_action -->
<div class="sidebar_head"><h2>ページの編集</h2></div>
<div class="sidebar_body">
<ul>
	<li class="pa_reload"><a href="index.php\?(.*)">リロード</a></li>
	<li class="pa_newpage"><a href="index.php\?plugin=newpage&amp;refer=(.*)">新規</a></li>
	<li class="pa_edit"><a href="index.php\?cmd=edit&amp;page=(.*)">編集</a></li>
	<li class="pa_freeze"><a href="index.php\?cmd=freeze&amp;page=(.*)">凍結</a></li>
	<li class="pa_attach"><a href="index.php\?plugin=attach&amp;pcmd=upload&amp;page=(.*)">添付</a></li>
	<li class="pa_diff"><a href="index.php\?cmd=diff&amp;page=(.*)">差分</a></li>
	<li class="pa_list"><a href="index.php\?cmd=list">一覧</a></li>
	<li class="pa_serch"><a href="index.php\?cmd=search">検索</a></li>
	<li class="pa_whatnew"><a href="index.php\?RecentChanges">最新</a></li>
	<li class="pa_backup"><a href="index.php\?cmd=backup&amp;page=(.*)">バックアップ</a></li>
	<li class="pa_help"><a href="index.php\?%A5%D8%A5%EB%A5%D7">ヘルプ</a></li>
</ul>
</div>
</div><!-- \?\?END id:page_action -->#
HOGE;

$hoge = '@"index.php\?([^#"]+)(#[^"]+)?"@';
$rep = '"$1.html$2"';

$hoge = '#<body>
#';
$rep = '
<body>
<div id="alert-message-top">ここは以前の ethna.jp サイトを表示したものです。ここにあるドキュメントはバージョン2.6以降更新されません。<br/>
最新のドキュメントは <a href="http://ethna.jp/">現在のethna.jp</a> を閲覧してください。現ドキュメントが整備されるまでは、ここを閲覧してください。</div>
';

foreach (glob('./*.html') as $file) {
    echo $file;
    $a = file_get_contents($file);
    //var_dump(substr_count($a, $hoge));
    $a = mb_convert_encoding(str_replace('EUC-JP', 'utf-8', $a), 'utf-8', 'euc-jp');
    //$a = preg_replace($hoge, '', $a);
    //$a = preg_replace($hoge, $rep, $a);
    //var_dump(preg_match_all($hoge, $a, $o));
    file_put_contents($file, $a);
}
