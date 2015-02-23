@faq-page
    Feature: FAQ page
        In order to access FAQ page
        I want to be able to see the FAQ page
    Scenario: Viewing FAQ page
        Given I am on "/en/faq"
         Then the response status code should be 200
          And I should see "F.A.Q." in the "h1" element
          And I should see "How i could ask some question" in the "dt" element
         When I follow "UK"
         Then the response status code should be 200
          And I should see "F.A.Q." in the "h1" element
          And I should see "Як я можу написати питання?" in the "dt" element
         When I follow "RU"
         Then the response status code should be 200
          And I should see "F.A.Q." in the "h1" element
          And I should see "Как я могу задать вопрос?" in the "dt" element
