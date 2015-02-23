@add-lost-items
Feature: Add lost items
    In order to access add lost item
    As a authorized user
    I want to be able to add lost item

    Scenario: Viewing the add lost item page
        Given I am authorized
          And I am on "/en/add-lost-item"
          And I should see "I lost something..." in the "h1" element
