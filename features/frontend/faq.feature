@faq
Feature: F.A.Q.
    In order to view the F.A.Q.
    As a visitor
    I want to be able to see the F.A.Q.

    Scenario: Viewing the F.A.Q. as a visitor
        Given there is default currency configured
          And I should see "F.A.Q." button
         When I press "F.A.Q."
         Then I should redirect on "F.A.Q." page
          And I should see "F.A.Q."
