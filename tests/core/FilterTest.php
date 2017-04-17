<?php

class FilterTest extends PHPUnit_Framework_TestCase
{
    /**
     * When argument contains bad code the encoded (and therefore un-dangerous) string should be returned
     */
    public function testXSSFilterWithBadCode()
    {
        $codeBefore = "Hello <script>var http = new XMLHttpRequest(); http.open('POST', 'example.com/my_account/delete.php', true);</script>";
        $codeAfter = "Hello &lt;script&gt;var http = new XMLHttpRequest(); http.open(&#039;POST&#039;, &#039;example.com/my_account/delete.php&#039;, true);&lt;/script&gt;";

        $this->assertEquals($codeAfter, Filter::XSSFilter($codeBefore));
    }

    /**
     * For every type other than strings the method should return the untouched passed argument
     */
    public function testXSSFilterWithNonStringArguments()
    {
        $integer = 123;
        $array = [1, 2, 3];
        $float = 17.001;

        $this->assertEquals($integer, Filter::XSSFilter($integer));
        $this->assertEquals($array, Filter::XSSFilter($array));
        $this->assertEquals($float, Filter::XSSFilter($float));
        $this->assertNull(Filter::XSSFilter(null));
    }
}
