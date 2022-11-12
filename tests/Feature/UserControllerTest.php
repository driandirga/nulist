<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user'=>'drian',
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login',[
            'user'=>'drian',
            'password'=>'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user','drian');
    }

    public function testLoginSuccessAlreadyLogin()
    {
        $this->withSession([
            'user'=>'drian',
        ])->post('/login',[
            'user'=>'drian',
            'password'=>'rahasia'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login',[])
            ->assertSeeText('User or Password is required');
    }

    public function testLoginFailed()
    {
        $this->post('/login',[
            'user'=>'ninjadog',
            'password'=>'123456'
        ])
            ->assertSeeText('User or Password is incorrect');
    }

    public function testLogout()
    {
        $this->withSession([
            'user'=>'drian'
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing('user');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
