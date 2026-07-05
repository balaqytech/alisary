<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public ?string $slogan;

    public ?string $logo_path;

    public ?string $email;

    public ?string $phone;

    public ?string $address;

    public ?string $assistant_url;

    public ?string $seo_title;

    public ?string $seo_description;

    public array $social_links;

    public array $job_submission_recipients;

    public array $tender_submission_recipients;

    public array $privacy_rights_recipients;

    /**
     * @return array<int, string>
     */
    public function jobSubmissionRecipientEmails(): array
    {
        return $this->recipientEmails($this->job_submission_recipients);
    }

    /**
     * @return array<int, string>
     */
    public function tenderSubmissionRecipientEmails(): array
    {
        return $this->recipientEmails($this->tender_submission_recipients);
    }

    /**
     * @return array<int, string>
     */
    public function privacyRightsRecipientEmails(): array
    {
        return $this->recipientEmails($this->privacy_rights_recipients);
    }

    /**
     * @param  array<int, array<string, mixed>>  $recipients
     * @return array<int, string>
     */
    protected function recipientEmails(array $recipients): array
    {
        return collect($recipients)
            ->pluck('email')
            ->filter(fn (mixed $email): bool => is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
            ->unique()
            ->values()
            ->all();
    }

    public static function group(): string
    {
        return 'general';
    }
}
