<?php
/**
 * Class EnhancedMeasurementSettingsModel
 *
 * @package   Google\Site_Kit\Modules\Analytics_4\GoogleAnalyticsAdmin
 * @copyright 2023 Google LLC
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://sitekit.withgoogle.com
 */

namespace Google\Site_Kit\Modules\Analytics_4\GoogleAnalyticsAdmin;

/**
 * The EnhancedMeasurementSettingsModel class.
 */
class EnhancedMeasurementSettingsModel extends \Google\Site_Kit_Dependencies\Google\Model {
    public $fileDownloadsEnabled;
    public $name;
    public $outboundClicksEnabled;
    public $pageChangesEnabled;
    public $scrollsEnabled;
    public $searchQueryParameter;
    public $siteSearchEnabled;
    public $streamEnabled;
    public $uriQueryParameter;
    public $videoEngagementEnabled;
    public function setFileDownloadsEnabled( $fileDownloadsEnabled )
    {
        $this->fileDownloadsEnabled = $fileDownloadsEnabled;
    }
    public function getFileDownloadsEnabled()
    {
        return $this->fileDownloadsEnabled;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setOutboundClicksEnabled($outboundClicksEnabled)
    {
        $this->outboundClicksEnabled = $outboundClicksEnabled;
    }
    public function getOutboundClicksEnabled()
    {
        return $this->outboundClicksEnabled;
    }
    public function setPageChangesEnabled($pageChangesEnabled)
    {
        $this->pageChangesEnabled = $pageChangesEnabled;
    }
    public function getPageChangesEnabled()
    {
        return $this->pageChangesEnabled;
    }
    public function setScrollsEnabled($scrollsEnabled)
    {
        $this->scrollsEnabled = $scrollsEnabled;
    }
    public function getScrollsEnabled()
    {
        return $this->scrollsEnabled;
    }
    public function setSearchQueryParameter($searchQueryParameter)
    {
        $this->searchQueryParameter = $searchQueryParameter;
    }
    public function getSearchQueryParameter()
    {
        return $this->searchQueryParameter;
    }
    public function setSiteSearchEnabled($siteSearchEnabled)
    {
        $this->siteSearchEnabled = $siteSearchEnabled;
    }
    public function getSiteSearchEnabled()
    {
        return $this->siteSearchEnabled;
    }
    public function setStreamEnabled($streamEnabled)
    {
        $this->streamEnabled = $streamEnabled;
    }
    public function getStreamEnabled()
    {
        return $this->streamEnabled;
    }
    public function setUriQueryParameter($uriQueryParameter)
    {
        $this->uriQueryParameter = $uriQueryParameter;
    }
    public function getUriQueryParameter()
    {
        return $this->uriQueryParameter;
    }
    public function setVideoEngagementEnabled($videoEngagementEnabled)
    {
        $this->videoEngagementEnabled = $videoEngagementEnabled;
    }
    public function getVideoEngagementEnabled()
    {
        return $this->videoEngagementEnabled;
    }
}
// Adding a class alias for backwards compatibility with the previous class name.
\class_alias(\Google\Site_Kit_Dependencies\Google\Service\GoogleAnalyticsAdmin\GoogleAnalyticsAdminV1alphaEnhancedMeasurementSettings::class, 'Google\\Site_Kit_Dependencies\\Google_Service_GoogleAnalyticsAdmin_GoogleAnalyticsAdminV1alphaEnhancedMeasurementSettings');
