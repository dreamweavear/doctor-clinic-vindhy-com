<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter;
use App\Filters\RoleFilter;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to
     * be used in the routes file.
     *
     * @var array<string, class-string|list<class-string>>
     */
    public array $aliases = [
        'auth' => AuthFilter::class ,
        'role' => RoleFilter::class ,
        'csrf' => CSRF::class ,
        'toolbar' => DebugToolbar::class ,
        'honeypot' => Honeypot::class ,
        'invalidchars' => InvalidChars::class ,
        'secureheaders' => SecureHeaders::class ,
        'cors' => Cors::class ,
        'forcehttps' => ForceHTTPS::class ,
        'pagecache' => PageCache::class ,
        'performance' => PerformanceMetrics::class ,
    ];

    /**
     * List of filter aliases that are always applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>
     */
    public array $required = [
        'before' => [
            // 'forcehttps', // Disabled for local development (enables for production)
            'pagecache', // Web Page Caching
        ],
        'after' => [
            'pagecache', // Web Page Caching
            'performance', // Performance Metrics
            'toolbar', // Debug Toolbar
        ],
    ];

    /**
     * Filters that are always applied before and after every request.
     */
    public array $globals = [
        'before' => [
            // 'honeypot',
            'csrf',
            // 'invalidchars',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * Filters that are applied per-method.
     */
    public array $methods = [];

    /**
     * List of filter aliases that works on a particular URI pattern.
     */
    public array $filters = [];
}
