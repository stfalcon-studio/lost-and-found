@lost-items
Feature: Lost items
    In order to see the lost items
    As a visitor
    I want to be able to see the lost items

    Scenario: Viewing the lost items list
        Given there is default currency configured
         Then I should see "Lost items" button
         When I press "Lost items"
         Then I should redirect on "Lost items" page
          And I should see "Lost items"
          And I should see list of categories
          And I should see map
