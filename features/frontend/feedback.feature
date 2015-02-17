@feedback
Feature: Feedback
    In order to view the Feedback
    As a visitor
    I want to be able to see the Feedback

    Scenario: Viewing the Feedback as a visitor
        Given there is default currency configured
          And I should see "Feedback" button
         When I press "Feedback"
         Then I should redirect on "Feedback" page
          And I should see "Feedback"
