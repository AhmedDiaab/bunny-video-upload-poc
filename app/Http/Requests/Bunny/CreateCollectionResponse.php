<?php
namespace App\Http\Requests\Bunny;

class CreateCollectionResponse
{
    public int $Id;
    public string $Name;
    public int $VideoCount;
    public int $TrafficUsage;
    public int $StorageUsage;
    public string $DateCreated;
    public array $ReplicationRegions;
    public string $ApiKey;
    public string $ReadOnlyApiKey;
    public bool $HasWatermark;
    public int $WatermarkPositionLeft;
    public int $WatermarkPositionTop;
    public int $WatermarkWidth;
    public int $PullZoneId;
    public int $StorageZoneId;
    public int $WatermarkHeight;
    public string $EnabledResolutions;
    public ?string $ViAiPublisherId;
    public ?string $VastTagUrl;
    public ?string $WebhookUrl;
    public int $CaptionsFontSize;
    public string $CaptionsFontColor;
    public string $CaptionsBackground;
    public string $UILanguage;
    public bool $AllowEarlyPlay;
    public bool $PlayerTokenAuthenticationEnabled;
    public array $AllowedReferrers;
    public array $BlockedReferrers;
    public bool $BlockNoneReferrer;
    public bool $EnableMP4Fallback;
    public bool $KeepOriginalFiles;
    public bool $AllowDirectPlay;
    public bool $EnableDRM;
    public int $DrmVersion;
    public DrmSettings $AppleFairPlayDrm;
    public WidevineDrmSettings $GoogleWidevineDrm;
    public int $Bitrate240p;
    public int $Bitrate360p;
    public int $Bitrate480p;
    public int $Bitrate720p;
    public int $Bitrate1080p;
    public int $Bitrate1440p;
    public int $Bitrate2160p;
    public ?string $ApiAccessKey;
    public bool $ShowHeatmap;
    public bool $EnableContentTagging;
    public int $PullZoneType;
    public ?string $CustomHTML;
    public string $Controls;
    public string $PlayerKeyColor;
    public string $FontFamily;
    public int $WatermarkVersion;
    public bool $EnableTranscribing;
    public bool $EnableTranscribingTitleGeneration;
    public bool $EnableTranscribingDescriptionGeneration;
    public array $TranscribingCaptionLanguages;
    public bool $RememberPlayerPosition;

    public function __construct(array $data)
    {
        $this->Id = $data['Id'];
        $this->Name = $data['Name'];
        $this->VideoCount = $data['VideoCount'];
        $this->TrafficUsage = $data['TrafficUsage'];
        $this->StorageUsage = $data['StorageUsage'];
        $this->DateCreated = $data['DateCreated'];
        $this->ReplicationRegions = $data['ReplicationRegions'];
        $this->ApiKey = $data['ApiKey'];
        $this->ReadOnlyApiKey = $data['ReadOnlyApiKey'];
        $this->HasWatermark = $data['HasWatermark'];
        $this->WatermarkPositionLeft = $data['WatermarkPositionLeft'];
        $this->WatermarkPositionTop = $data['WatermarkPositionTop'];
        $this->WatermarkWidth = $data['WatermarkWidth'];
        $this->PullZoneId = $data['PullZoneId'];
        $this->StorageZoneId = $data['StorageZoneId'];
        $this->WatermarkHeight = $data['WatermarkHeight'];
        $this->EnabledResolutions = $data['EnabledResolutions'];
        $this->ViAiPublisherId = $data['ViAiPublisherId'];
        $this->VastTagUrl = $data['VastTagUrl'];
        $this->WebhookUrl = $data['WebhookUrl'];
        $this->CaptionsFontSize = $data['CaptionsFontSize'];
        $this->CaptionsFontColor = $data['CaptionsFontColor'];
        $this->CaptionsBackground = $data['CaptionsBackground'];
        $this->UILanguage = $data['UILanguage'];
        $this->AllowEarlyPlay = $data['AllowEarlyPlay'];
        $this->PlayerTokenAuthenticationEnabled = $data['PlayerTokenAuthenticationEnabled'];
        $this->AllowedReferrers = $data['AllowedReferrers'];
        $this->BlockedReferrers = $data['BlockedReferrers'];
        $this->BlockNoneReferrer = $data['BlockNoneReferrer'];
        $this->EnableMP4Fallback = $data['EnableMP4Fallback'];
        $this->KeepOriginalFiles = $data['KeepOriginalFiles'];
        $this->AllowDirectPlay = $data['AllowDirectPlay'];
        $this->EnableDRM = $data['EnableDRM'];
        $this->DrmVersion = $data['DrmVersion'];
        $this->AppleFairPlayDrm = new DrmSettings($data['AppleFairPlayDrm']);
        $this->GoogleWidevineDrm = new WidevineDrmSettings($data['GoogleWidevineDrm']);
        $this->Bitrate240p = $data['Bitrate240p'];
        $this->Bitrate360p = $data['Bitrate360p'];
        $this->Bitrate480p = $data['Bitrate480p'];
        $this->Bitrate720p = $data['Bitrate720p'];
        $this->Bitrate1080p = $data['Bitrate1080p'];
        $this->Bitrate1440p = $data['Bitrate1440p'];
        $this->Bitrate2160p = $data['Bitrate2160p'];
        $this->ApiAccessKey = $data['ApiAccessKey'];
        $this->ShowHeatmap = $data['ShowHeatmap'];
        $this->EnableContentTagging = $data['EnableContentTagging'];
        $this->PullZoneType = $data['PullZoneType'];
        $this->CustomHTML = $data['CustomHTML'];
        $this->Controls = $data['Controls'];
        $this->PlayerKeyColor = $data['PlayerKeyColor'];
        $this->FontFamily = $data['FontFamily'];
        $this->WatermarkVersion = $data['WatermarkVersion'];
        $this->EnableTranscribing = $data['EnableTranscribing'];
        $this->EnableTranscribingTitleGeneration = $data['EnableTranscribingTitleGeneration'];
        $this->EnableTranscribingDescriptionGeneration = $data['EnableTranscribingDescriptionGeneration'];
        $this->TranscribingCaptionLanguages = $data['TranscribingCaptionLanguages'];
        $this->RememberPlayerPosition = $data['RememberPlayerPosition'];
    }
}

class DrmSettings
{
    public bool $Enabled;
    public ?int $CertificateId;
    public ?string $CertificateExpirationDate;
    public ?string $Provider;

    public function __construct(array $data)
    {
        $this->Enabled = $data['Enabled'];
        $this->CertificateId = $data['CertificateId'];
        $this->CertificateExpirationDate = $data['CertificateExpirationDate'];
        $this->Provider = $data['Provider'];
    }
}

class WidevineDrmSettings extends DrmSettings
{
    public bool $SdOnlyForL3;
    public ?int $MinClientSecurityLevel;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->SdOnlyForL3 = $data['SdOnlyForL3'];
        $this->MinClientSecurityLevel = $data['MinClientSecurityLevel'];
    }
}
