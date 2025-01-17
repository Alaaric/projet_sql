<?php

namespace App\Controllers;


class HomeController extends AbstractController
{
  public function index()
  {

    $this->render('home');
  }

  public function privacyPolicy()
  {
    $this->render('privacyPolicy');
  }

  public function contact()
  {
    $this->render('contact');
  }

  public function about()
  {
    $this->render('about');
  }

}