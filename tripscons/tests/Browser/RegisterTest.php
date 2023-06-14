<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $randomNo = rand(1, 10000);
            $browser->visit('http://localhost:3000')
                ->press('@signup-button')
                ->assertSee('Sign up')
                ->type('@email-input', 'sufyan' . $randomNo . '@gmail.com')
                ->type('@name', 'abu_sufyan')
                ->type('@password', 'User@123')
                ->type('@c_password', 'User@123')
                ->check('@verify-checkbox')
                ->press('@signup')
                ->pause(10000)
                ->assertPathIs('/');
        });
    }
    protected function hasHeadlessDisabled(): bool
    {
        return false;
    }
}
