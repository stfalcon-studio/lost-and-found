@lost-items-page
Feature: Lost items page
    In order to access the lost items page
    As a authorized user
    I want to be able to see the lost items page

    Scenario: Viewing lost items page
        Given I am on "/en/lost-items"
         Then the response status code should be 200
          And I should see "Lost items" in the "h1" element
#       TODO: Programmatically facebook api login
          And I should see "I lost something :(" in the "a.btn.btn-danger" element
         When I click on "a.btn.btn-danger" element
          And I should be on "/en/add-lost-item"
         Then the response status code should be 200
          And I should see "I lost something..." in the "h1" element
