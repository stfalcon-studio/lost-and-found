@homepage
Feature: Homepage
    In order to access the homepage
    As a visitor
    I want to be able to see the homepage

    Scenario: Viewing the homepage as a visitor
        Given I am on "/"
         Then the response status code should be 200
          And I should see "Lost and Found" in the "h1" element
          And I should see "Web-service for announcements of lost and found items. Was created by students from Khmelnytskyi Polytechnic College during their practice at Studio Stfalcon.com" in the ".well" element

    Scenario: Viewing the homepage
        Given I am on "/"
         When I follow "Lost and Found"
         Then the response status code should be 200
          And I should see "Lost and Found" in the "h1" element
          And I should see "Web-service for announcements of lost and found items. Was created by students from Khmelnytskyi Polytechnic College during their practice at Studio Stfalcon.com" in the ".well" element

    Scenario: Viewing the lost-items list
        Given I am on "/"
         When I follow "Lost items"
         Then the response status code should be 200
          And I should be on "/lost-items"
          And I should see "Lost items" in the "h1" element

    Scenario: Viewing the found-items list
        Given I am on "/"
         When I follow "Found items"
         Then the response status code should be 200
          And I should be on "/found-items"
          And I should see "Found items" in the "h1" element

    Scenario: Viewing the F.A.Q.
        Given I am on "/"
         When I follow "F.A.Q."
         Then the response status code should be 200
          And I should be on "/faq"
          And I should see "F.A.Q." in the "h1" element

    Scenario: Viewing the Feedback
        Given I am on "/"
         When I follow "Feedback"
         Then the response status code should be 200
          And I should be on "/feedback"
          And I should see "Feedback" in the "h1" element

    Scenario: Logging into service
        Given I am on "/"
         When I follow "Login with Facebook"
         Then the response status code should be 200
          And I should be on "/"
          And I should see "I lost something :(" in the ".btn .btn-danger" element
          And I should see "I found something :)" in the ".btn .btn-success" element
