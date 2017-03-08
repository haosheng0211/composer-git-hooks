<?php

use BrainMaestro\GitHooks\Hook;

trait PrepareHookTest
{
    private static $hooks = [
        'test-pre-commit' => 'echo before-commit',
        'test-post-commit' => 'echo after-commit',
    ];

    public function setUp()
    {
        self::prepare();
    }

    public static function tearDownAfterClass()
    {
        self::prepare();
    }

    private static function prepare()
    {
        foreach (array_keys(self::$hooks) as $hook) {
            if (file_exists(".git/hooks/{$hook}")) {
                unlink(".git/hooks/{$hook}");
            }
        }

        if (file_exists(Hook::LOCK_FILE)) {
            unlink(Hook::LOCK_FILE);
        }

        passthru('sed -i "" /' . Hook::LOCK_FILE . '/d .gitignore');
    }
}
