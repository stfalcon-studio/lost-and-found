@homepage
Feature: Homepage
    In order to access the homepage
    As a visitor
    I want to be able to see the homepage

    Scenario: Viewing the homepage as a visitor
        Given there is default currency configured
         When I go to the website root
         Then I should be on the homepage
          And I should see "Lost And Found"
