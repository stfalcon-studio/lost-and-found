@found-items
Feature: Lost items
    In order to see the found items
    As a visitor
    I want to be able to see the found items

    Scenario: Viewing the found items list
        Given there is default currency configured
         Then I should see "Found items" button
         When I press "Found items"
         Then I should redirect on "Found items" page
          And I should see "Found items"
          And I should see list of categories
          And I should see map
