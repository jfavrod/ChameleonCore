<?php

/**
 * HtmlHeadTest
 *
 * Tests the HtmlHead Class.
 *
 * @author Jason Favrod <jason@epoquecorporation.com>
 *
 */

use PHPUnit\Framework\TestCase;
use Epoque\Chameleon\HtmlHead;

define('SITE_TITLE', 'testing site title');


final class HtmlHeadTest extends TestCase
{
    /**
     * testBeginEndHeadTags
     *
     */

    public function testBeginEndHeadTags()
    {
        $htmlhead = new HtmlHead('testing');
        $headarray = preg_split('/\n/', $htmlhead);
        $this->assertContains('<head>', $headarray);
        $this->assertContains('</head>', $headarray);

        return $htmlhead;
    }
}

