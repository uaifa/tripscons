<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://localhost:3000')
                ->press('@login-button')
                ->assertSee('Login')
                ->type('email', 'xilaverivi@mailinator.com')
                ->type('password', 'User@123')
                ->press('#btn-login')
                ->pause(10000)
                ->assertPathIs('/')
            ;

        });
    }
    protected function hasHeadlessDisabled(): bool
    {
        return true;
    }
}
