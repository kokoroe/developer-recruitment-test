<?php
/*
 * This file is part of the developer-recruitment-test.
 *
 * (c) Kokoroe <contact@kokoroe.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kokoroe\Recruitment\Test;

use Kokoroe\Recruitment\Version;

/**
 * @see http://semver.org/spec/v2.0.0.html
 */
class VersionTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleStableVersion()
    {
        $version = new Version('1.2.3');

        $this->assertTrue($version->isValid());
        $this->assertTrue($version->isStable());
        $this->assertEquals('1.2.3', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(2, $version->getMinor());
        $this->assertEquals(3, $version->getPatch());
        $this->assertEquals(Version::PRE_RELEASE_NONE, $version->getPreReleaseType());
        $this->assertNull($version->getPreRelease());
        $this->assertNull($version->getBuild());

        $version = new Version('0.0.1');

        $this->assertTrue($version->isValid());
        $this->assertFalse($version->isStable());
        $this->assertEquals('0.0.1', (string) $version);
        $this->assertEquals(0, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(1, $version->getPatch());
        $this->assertEquals(Version::PRE_RELEASE_NONE, $version->getPreReleaseType());
        $this->assertNull($version->getPreRelease());
        $this->assertNull($version->getBuild());
    }

    public function testSimpleErrorVersion()
    {
        $version = new Version('a.b.c');

        $this->assertFalse($version->isValid());
        $this->assertEquals('a.b.c', (string) $version);
        $this->assertEquals(0, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertNull($version->getPreRelease());
        $this->assertNull($version->getBuild());

        $version = new Version('0.b.c');

        $this->assertFalse($version->isValid());
        $this->assertEquals('0.b.c', (string) $version);
        $this->assertEquals(0, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertNull($version->getPreRelease());
        $this->assertNull($version->getBuild());

        $version = new Version('0.1.c');

        $this->assertFalse($version->isValid());
        $this->assertEquals('0.1.c', (string) $version);
        $this->assertEquals(0, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertNull($version->getPreRelease());
        $this->assertNull($version->getBuild());

        $version = new Version('0.0.0');

        $this->assertFalse($version->isValid());
        $this->assertEquals('0.0.0', (string) $version);
        $this->assertEquals(0, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertNull($version->getPreRelease());
        $this->assertNull($version->getBuild());

        $version = new Version('');

        $this->assertFalse($version->isValid());
        $this->assertEquals('', (string) $version);
        $this->assertEquals(0, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertNull($version->getPreRelease());
        $this->assertNull($version->getBuild());
    }

    public function testErrorVersion()
    {
        $version = new Version('1.0.0-alpha.01');

        $this->assertFalse($version->isValid());
        $this->assertEquals('1.0.0-alpha.01', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertEquals('alpha.01', $version->getPreRelease());
        $this->assertNull($version->getBuild());

        $version = new Version('1.0.0-alpha$z');

        $this->assertFalse($version->isValid());
        $this->assertEquals('1.0.0-alpha$z', (string) $version);
        $this->assertEquals(0, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertEquals('alpha$z', $version->getPreRelease());
        $this->assertNull($version->getBuild());

        $version = new Version('1.0.0-alpha+azzerz&e');

        $this->assertFalse($version->isValid());
        $this->assertEquals('1.0.0-alpha+azzerz&e', (string) $version);
        $this->assertEquals(0, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertEquals('alpha', $version->getPreRelease());
        $this->assertEquals('azzerz&e', $version->getBuild());

        $version = new Version('1.0.0-alpha.1&e');

        $this->assertFalse($version->isValid());
        $this->assertEquals('1.0.0-alpha.1&e', (string) $version);
        $this->assertEquals(0, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertEquals('alpha.1&e', $version->getPreRelease());
        $this->assertEquals('1&e', $version->getPreReleaseId());
        $this->assertNull($version->getBuild());
    }

    public function testPreReleaseVersion()
    {
        $version = new Version('1.2.3-beta');

        $this->assertTrue($version->isValid());
        $this->assertFalse($version->isStable());
        $this->assertEquals('1.2.3-beta', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(2, $version->getMinor());
        $this->assertEquals(3, $version->getPatch());
        $this->assertEquals(Version::PRE_RELEASE_BETA, $version->getPreReleaseType());
        $this->assertEquals('beta', $version->getPreRelease());
        $this->assertNull($version->getBuild());

        $version = new Version('1.0.0-alpha');

        $this->assertTrue($version->isValid());
        $this->assertFalse($version->isStable());
        $this->assertEquals('1.0.0-alpha', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertEquals(Version::PRE_RELEASE_ALPHA, $version->getPreReleaseType());
        $this->assertEquals('alpha', $version->getPreRelease());
        $this->assertNull($version->getBuild());

        $version = new Version('1.0.0-alpha.1');

        $this->assertTrue($version->isValid());
        $this->assertFalse($version->isStable());
        $this->assertEquals('1.0.0-alpha.1', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertEquals(Version::PRE_RELEASE_ALPHA, $version->getPreReleaseType());
        $this->assertEquals('alpha.1', $version->getPreRelease());
        $this->assertEquals('1', $version->getPreReleaseId());
        $this->assertNull($version->getBuild());

        $version = new Version('1.0.0-rc.1');

        $this->assertTrue($version->isValid());
        $this->assertFalse($version->isStable());
        $this->assertEquals('1.0.0-rc.1', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertEquals(Version::PRE_RELEASE_RC, $version->getPreReleaseType());
        $this->assertEquals('rc.1', $version->getPreRelease());
        $this->assertEquals('1', $version->getPreReleaseId());
        $this->assertNull($version->getBuild());

        $version = new Version('1.0.0-rc-beta.1');

        $this->assertTrue($version->isValid());
        $this->assertFalse($version->isStable());
        $this->assertEquals('1.0.0-rc-beta.1', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(0, $version->getMinor());
        $this->assertEquals(0, $version->getPatch());
        $this->assertEquals('rc-beta.1', $version->getPreRelease());
        $this->assertEquals('1', $version->getPreReleaseId());
        $this->assertNull($version->getBuild());
    }

    public function testBuildVersion()
    {
        $version = new Version('1.2.3-beta+20130101133700');

        $this->assertTrue($version->isValid());
        $this->assertFalse($version->isStable());
        $this->assertEquals('1.2.3-beta+20130101133700', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(2, $version->getMinor());
        $this->assertEquals(3, $version->getPatch());
        $this->assertEquals('beta', $version->getPreRelease());
        $this->assertEquals('20130101133700', $version->getBuild());


        $version = new Version('1.2.3-beta.1+20130101133700');

        $this->assertTrue($version->isValid());
        $this->assertFalse($version->isStable());
        $this->assertEquals('1.2.3-beta.1+20130101133700', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(2, $version->getMinor());
        $this->assertEquals(3, $version->getPatch());
        $this->assertEquals('beta.1', $version->getPreRelease());
        $this->assertEquals('1', $version->getPreReleaseId());
        $this->assertEquals('20130101133700', $version->getBuild());

        $version = new Version('1.2.3-rc-beta+20130101133700');

        $this->assertTrue($version->isValid());
        $this->assertFalse($version->isStable());
        $this->assertEquals('1.2.3-rc-beta+20130101133700', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(2, $version->getMinor());
        $this->assertEquals(3, $version->getPatch());
        $this->assertEquals('rc-beta', $version->getPreRelease());
        $this->assertEquals('20130101133700', $version->getBuild());

        $version = new Version('1.2.3+20130101133700');

        $this->assertTrue($version->isValid());
        $this->assertTrue($version->isStable());
        $this->assertEquals('1.2.3+20130101133700', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(2, $version->getMinor());
        $this->assertEquals(3, $version->getPatch());
        $this->assertNull($version->getPreRelease());
        $this->assertEquals('20130101133700', $version->getBuild());

        $version = new Version('1.2.3+20130101133700-foo');

        $this->assertTrue($version->isValid());
        $this->assertTrue($version->isStable());
        $this->assertEquals('1.2.3+20130101133700-foo', (string) $version);
        $this->assertEquals(1, $version->getMajor());
        $this->assertEquals(2, $version->getMinor());
        $this->assertEquals(3, $version->getPatch());
        $this->assertNull($version->getPreRelease());
        $this->assertEquals('20130101133700-foo', $version->getBuild());
    }
}
