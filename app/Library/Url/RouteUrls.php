<?php

namespace App\Library\Url;

class RouteUrls
{

    public function localizeUrl($url = '', $modular = '')
    {
        $locale = app()->getLocale();

        if ($modular) $modular .= '/';

        return url("{$locale}/{$modular}{$url}");
    }

    /**
     * @Section Admin
     */

    function home()
    {
        return $this->localizeUrl('/', 'control');
    }

    function control()
    {
        return $this->localizeUrl('/', 'control');
    }

    function gallery()
    {
        return $this->localizeUrl('gallery', 'control');
    }

    function resumeApply()
    {
        return $this->localizeUrl('resume-apply', 'control');
    }

    function jobApply()
    {
        return $this->localizeUrl('job-apply', 'control');
    }

    function logout()
    {
        return $this->localizeUrl('logout', '');
    }

    function users()
    {
        return $this->localizeUrl('users', 'control');
    }

    function categories()
    {
        return $this->localizeUrl('categories', 'control');
    }

    function counter()
    {
        return $this->localizeUrl('counters', 'control');
    }

    function socialNetworks()
    {
        return $this->localizeUrl('social-networks', 'control');
    }

    function faqTypes()
    {
        return $this->localizeUrl('faq-types', 'control');
    }

    function faqs()
    {
        return $this->localizeUrl('faqs', 'control');
    }

    function news()
    {
        return $this->localizeUrl('news', 'control');
    }

    function companyEmployers()
    {
        return $this->localizeUrl('company-employers', 'control');
    }

    function pages()
    {
        return $this->localizeUrl('pages', 'control');
    }

    function companies()
    {
        return $this->localizeUrl('companies', 'control');
    }

    function resumes()
    {
        return $this->localizeUrl('resumes', 'control');
    }

    function contracts()
    {
        return $this->localizeUrl('contracts','control');
    }

    function applyStatuses()
    {
        return $this->localizeUrl('apply-statuses','control');
    }

    function schools()
    {
        return $this->localizeUrl('schools','control');
    }

    function degrees()
    {
        return $this->localizeUrl('degrees','control');
    }

    function majers()
    {
        return $this->localizeUrl('majers','control');
    }

    function skills()
    {
        return $this->localizeUrl('skills','control');
    }

    function hourlyRates()
    {
        return $this->localizeUrl('hourly-rates','control');
    }

    function tagLists()
    {
        return $this->localizeUrl('tag-lists','control');
    }

    function experienceCompanies()
    {
        return $this->localizeUrl('work-experience-companies','control');
    }

    function experienceJobTitles()
    {
        return $this->localizeUrl('work-experience-job-titles','control');
    }

    /**
     * @Section Web Site Urls
     */

    function site_home()
    {
        return $this->localizeUrl('/');
    }

    function site_register()
    {
        return $this->localizeUrl('register');
    }

    function site_login()
    {
        return $this->localizeUrl('login');
    }

    function site_passwordReset()
    {
        return $this->localizeUrl('password/reset');
    }

    function site_passwordEmail()
    {
        return $this->localizeUrl('password/email');
    }

    function site_jobs()
    {
        return $this->localizeUrl('jobs');
    }

    function site_my_jobs()
    {
        return $this->localizeUrl('my-jobs');
    }

    function site_job_detail($id)
    {
        return $this->localizeUrl("job/$id");
    }

    function site_job_detail_apply($id)
    {
        return $this->localizeUrl("job/$id/apply");
    }

    function site_job_mark_filled()
    {
        return $this->localizeUrl("job/filled");
    }

    function site_job_suggestion()
    {
        return $this->localizeUrl("job/suggestion");
    }

    function site_resume_suggestion()
    {
        return $this->localizeUrl("resume/suggestion");
    }

    function site_job_apply_send($id)
    {
        return $this->localizeUrl("job/$id/apply/send");
    }

    function site_job_category($id)
    {
        return $this->localizeUrl("category/$id/jobs");
    }

    function site_resumes()
    {
        return $this->localizeUrl('resumes');
    }

    function site_my_resumes()
    {
        return $this->localizeUrl('my-resumes');
    }

    function site_resume_detail($id)
    {
        return $this->localizeUrl("resume/$id");
    }

    function site_resume_detail_apply($id)
    {
        return $this->localizeUrl("resume/$id/apply");
    }

    function site_resume_apply_send($id)
    {
        return $this->localizeUrl("resume/$id/apply/send");
    }

    function site_companies()
    {
        return $this->localizeUrl('companies');
    }

    function site_my_companies()
    {
        return $this->localizeUrl('my-companies');
    }

    function site_company_detail($id)
    {
        return $this->localizeUrl("company/$id");
    }

    function site_news()
    {
        return $this->localizeUrl('news');
    }

    function site_about()
    {
        return $this->localizeUrl('about');
    }

    function site_contact()
    {
        return $this->localizeUrl('contact');
    }

    function site_faq()
    {
        return $this->localizeUrl('faq');
    }

    function site_profile()
    {
        return $this->localizeUrl('profile');
    }

    function site_gallery()
    {
        return $this->localizeUrl('gallery');
    }

    function site_logout()
    {
        return $this->localizeUrl('logout');
    }

    function site_like($model = '', $id = '')
    {
        $id = $id ? "/$id" : '';
        $model = $model ? "/$model{$id}" : '';

        return $this->localizeUrl("like{$model}");
    }

    function site_comment($model = '')
    {
        $model = $model ? "/$model" : '';

        return $this->localizeUrl("comment{$model}");
    }

    function site_rate($model = '', $id = '')
    {
        $id = $id ? "/$id" : '';
        $model = $model ? "/$model{$id}" : '';

        return $this->localizeUrl("rate{$model}");
    }
}
