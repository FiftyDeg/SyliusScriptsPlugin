Feature: Rendering scripts
    In order to use my favourite CDN scripts
    As a Store Owner
    I create them with this plugin

    @rendering_scripts @ui
    Scenario: Rendering sylius.shop.layout.head script
        When a customer visits the homepage
        Then the script with id "syliusShopLayoutHeadScript" is found in page

    @rendering_scripts @ui
    Scenario: Rendering sylius.shop.layout.before_body script
        When a customer visits the homepage
        Then the script with id "syliusShopLayoutBeforeBodyScript" is found in page

    @rendering_scripts @ui
    Scenario: Rendering sylius.shop.layout.after_body script
        When a customer visits the homepage
        Then the script with id "syliusShopLayoutAfterBodyScript" is found in page
