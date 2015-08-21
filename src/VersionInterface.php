<?php
/*
 * This file is part of the developer-recruitment-test.
 *
 * (c) Kokoroe <contact@kokoroe.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kokoroe\Recruitment;

interface VersionInterface
{
    const PRE_RELEASE_ALPHA = 1;
    const PRE_RELEASE_BETA  = 2;
    const PRE_RELEASE_RC    = 3;
    const PRE_RELEASE_NONE  = 4;

    /**
     * Get the major of the version
     *
     * @return integer
     */
    public function getMajor();

    /**
     * Get the minor of the version
     *
     * @return integer
     */
    public function getMinor();

    /**
     * Get the patch of the version
     *
     * @return integer
     */
    public function getPatch();

    /**
     * Get the build of the version
     *
     * @return string
     */
    public function getBuild();

    /**
     * Get the release type of the version
     */
    public function getPreReleaseType();

    /**
     * Get the release identifier of the version
     */
    public function getPreReleaseId();

    /**
     * Get the release of the version
     */
    public function getPreRelease();

    /**
     * Check if the version is valid
     *
     * @return boolean
     */
    public function isValid();

    /**
     * Check if the version is stable
     *
     * @return boolean
     */
    public function isStable();

    /**
     * Get full version
     *
     * @return string
     */
    public function __toString();
}
