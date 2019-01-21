<?php

/**
 *  you must add here route and model and view foreach
 *
 *  model             : you must add model for datatable
 *  dataTableFunc     : default funcName is get_datatable // add name for maker method ,this name will be used in maker class or in factory class as get_func / build_func / store_func / update_fund / destroy_func
 *  middlewares       : you can make auth by pass string or array to this property
 *  middlewaresOption : this option allow you to only make auth on on action or except action from auth by pass array
 *  request           : this is must be Form Request Class
 *  stopOperation     : for stop normal oper and add custom oper ['store','update','destroy']
 *  factory           : the default factory is  modelFactory unless you add you own factory property
 *
 */

return [

    'users' => [
        'model'   => App\User::class,
        'factory' => \Modules\Control\Factories\UserFactory::class,
    ],

    'categories' => [
        'model'   => \Modules\Control\Entities\Category::class,
        'factory' => \Modules\Control\Factories\CategoryFactory::class,
    ],

    'faqs' => [
        'model'   => \Modules\Control\Entities\Faq::class,
        'factory' => \Modules\Control\Factories\FaqFactory::class,
    ],

    'faq-types' => [
        'model'   => \Modules\Control\Entities\FaqType::class,
        'factory' => \Modules\Control\Factories\FaqTypeFactory::class,
    ],

    'contracts' => [
        'model'   => \Modules\Control\Entities\Contract::class,
        'factory' => \Modules\Control\Factories\ContractFactory::class,
    ],

    'apply-statuses' => [
        'model'   => \Modules\Control\Entities\ApplyStatus::class,
        'factory' => \Modules\Control\Factories\ApplyStatusFactory::class,
    ],

    'schools' => [
        'model'   => \Modules\Control\Entities\School::class,
        'factory' => \Modules\Control\Factories\SchoolFactory::class,
    ],

    'degrees' => [
        'model'   => \Modules\Control\Entities\Degree::class,
        'factory' => \Modules\Control\Factories\DegreeFactory::class,
    ],

    'majers' => [
        'model'   => \Modules\Control\Entities\Majer::class,
        'factory' => \Modules\Control\Factories\MajerFactory::class,
    ],

    'skills' => [
        'model'   => \Modules\Control\Entities\Skill::class,
        'factory' => \Modules\Control\Factories\SkillFactory::class,
    ],

    'social-networks' => [
        'model'   => \Modules\Control\Entities\SocialNetwork::class,
        'factory' => \Modules\Control\Factories\SocialNetworkFactory::class,
    ],

    'tag-lists' => [
        'model'   => \Modules\Control\Entities\TagList::class,
        'factory' => \Modules\Control\Factories\TagListFactory::class,
    ],

    'hourly-rates' => [
        'model'   => \Modules\Control\Entities\HourlyRate::class,
        'factory' => \Modules\Control\Factories\HourlyRateFactory::class,
    ],

    'company-employers' => [
        'model'   => \Modules\Control\Entities\CompanyEmployer::class,
        'factory' => \Modules\Control\Factories\CompanyEmployerFactory::class,
    ],

    'work-experience-job-titles' => [
        'model'   => \Modules\Control\Entities\WorkExpJobTitle::class,
        'factory' => \Modules\Control\Factories\WorkExpJobTitleFactory::class,
    ],

    'work-experience-companies' => [
        'model'   => \Modules\Control\Entities\WorkExpCompany::class,
        'factory' => \Modules\Control\Factories\WorkExpCompanyFactory::class,
    ],

    'counters' => [
        'model'   => \Modules\Control\Entities\Counter::class,
        'factory' => \Modules\Control\Factories\CounterFactory::class,
    ],

    'news' => [
        'model'   => \Modules\Control\Entities\News::class,
        'factory' => \Modules\Control\Factories\NewsFactory::class,
    ],

    'companies' => [
        'model'   => \Modules\Control\Entities\Company::class,
        'factory' => \Modules\Control\Factories\CompanyFactory::class,
        'stopOperation' => ['store']
    ],

    'resumes' => [
        'model'   => \Modules\Control\Entities\Resume::class,
        'factory' => \Modules\Control\Factories\ResumeFactory::class,
        'stopOperation' => ['store']
    ],

    'resume-skills' => [
        'model'   => \Modules\Control\Entities\ResumeSkill::class,
        'factory' => \Modules\Control\Factories\ResumeSkillFactory::class,
        'stopOperation' => ['store','update'],
    ],

    'resume-educations' => [
        'model'   => \Modules\Control\Entities\ResumeEducation::class,
        'factory' => \Modules\Control\Factories\ResumeEducationFactory::class,
    ],

    'work-experiences' => [
        'model'   => \Modules\Control\Entities\WorkExperience::class,
        'factory' => \Modules\Control\Factories\WorkExperienceFactory::class,
    ],

    'jobs' => [
        'model'   => \Modules\Control\Entities\Job::class,
        'factory' => \Modules\Control\Factories\JobFactory::class,
    ],

//    'gallery' => [
//        'model'   => \Modules\Control\Entities\Gallery::class,
//        'factory' => \Modules\Control\Factories\GalleryFactory::class,
//    ],

    'resume-apply' => [
        'model'   => \Modules\Control\Entities\JobApply::class,
        'factory' => \Modules\Control\Factories\ResumeApplyFactory::class,
    ],

    'job-apply' => [
        'model'   => \Modules\Control\Entities\JobApply::class,
        'factory' => \Modules\Control\Factories\JobApplyFactory::class,
    ],

    'comments' => [
        'model' => \Modules\Control\Entities\Comment::class,
        'factory' => \Modules\Control\Factories\CommentFactory::class,
    ]
];
