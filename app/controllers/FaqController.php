<?php

class FaqController
{
    public function index()
    {
        // Récupération des questions/réponses
        $faqs = Faq::getAll();

        require __DIR__ . '/../views/faq.php';
    }
}