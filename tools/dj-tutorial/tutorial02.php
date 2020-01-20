<?php

require_once "webauto.php";

use Goutte\Client;

$adminpw = substr(getMD5(),4,9);
$qtext = 'Answer to the Ultimate Question';
?>
<h1>Django Tutorial 02</h1>
<p>
For this assignment work through Part 2 of the Django tutorial at
<a href="https://docs.djangoproject.com/en/3.0/intro/tutorial02/" target="_blank">
https://docs.djangoproject.com/en/3.0/intro/tutorial02/</a>.
</a>
</p>
<p>
Once you have completed tutorial, make a second admin user with the following information:
<pre>
Account: dj4e
Password: <?= htmlentities($adminpw) ?>
</pre>
You can use any email address you like.
</p>
<p>
Then create a
<a href="https://en.wikipedia.org/wiki/Phrases_from_The_Hitchhiker%27s_Guide_to_the_Galaxy" target="_blank">question</a> with the exact text:
<pre>
<?= $qtext ?>
</pre>
Have at three answers and at least one answer be "42"
and submit your Django admin url to the autograder.
</p>
<?php

$url = getUrl('http://djtutorial.dj4e.com/admin');
if ( $url === false ) return;
$passed = 0;

$admin = $url;
error_log("Tutorial02 ".$url);

// http://symfony.com/doc/current/components/dom_crawler.html
$client = new Client();
$client->setMaxRedirects(5);

$crawler = webauto_get_url($client, $admin);
$html = webauto_get_html($crawler);

// line_out('Looking for the form with a value="Log In" submit button');
$form = webauto_get_form_with_button($crawler,'Log in');
webauto_change_form($form, 'username', 'dj4e');
webauto_change_form($form, 'password', $adminpw);

$crawler = $client->submit($form);
$html = webauto_get_html($crawler);

if ( strpos($html,'Log in') > 0 ) {
    error_out('It looks like you have not yet set up the admin account with dj4e / '.$adminpw);
    error_out('The test cannot be continued');
    return;
} else {
    line_out("Login successful...");
}

$link = webauto_get_href($crawler,'Questions');
$url = $link->getURI();
$crawler = webauto_get_url($client, $url);
$html = webauto_get_html($crawler);

markTestPassed('Questions page retrieved');

line_out("Looking for '$qtext'");
if ( strpos($html,$qtext) < 1 ) {
    error_out('It looks like you have not created a question with text');
    error_out($qtext);
    error_out('The test cannot be continued');
    return;
}

line_out("Found '$qtext'");
$passed++;

// -------
line_out(' ');
$perfect = 3;
$score = webauto_compute_effective_score($perfect, $passed, $penalty);

if ( $score < 1.0 ) autoToggle();

// Send grade
if ( $score > 0.0 ) webauto_test_passed($score, $url);

