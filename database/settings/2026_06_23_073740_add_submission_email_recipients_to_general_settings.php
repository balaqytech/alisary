<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.job_submission_recipients', []);
        $this->migrator->add('general.tender_submission_recipients', []);
    }
};
