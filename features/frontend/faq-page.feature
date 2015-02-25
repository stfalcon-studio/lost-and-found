@faq-page
    Feature: FAQ page
        In order to access FAQ page
        I want to be able to see the FAQ page

    Scenario: Viewing translation at english language
        Given I am on "/en/faq"
         Then the response status code should be 200
          And I should see "F.A.Q." in the "h1" element
          And I should see "How i could ask some question" in the "dt" element

    Scenario: Viewing translation at ukraine language
        Given I am on "/uk/faq"
         Then the response status code should be 200
          And I should see "F.A.Q." in the "h1" element
          And I should see "Як я можу написати питання?" in the "dt" element

    Scenario: Viewing translation at russian language
        Given I am on "/ru/faq"
         Then the response status code should be 200
          And I should see "F.A.Q." in the "h1" element
          And I should see "Как я могу задать вопрос?" in the "dt" element

    Scenario: Switch from ukraine language to english
        Given I am on "/uk/faq"
         When I follow "EN"
         Then the response status code should be 200
          And I should be on "/en/faq"

    Scenario: Switch from russian language to english
        Given I am on "/ru/faq"
        When I follow "EN"
        Then the response status code should be 200
         And I should be on "/en/faq"

    Scenario: Switch from english language to ukraine
        Given I am on "/en/faq"
        When I follow "UK"
        Then the response status code should be 200
         And I should be on "/uk/faq"

    Scenario: Switch from russian language to ukraine
        Given I am on "/ru/faq"
        When I follow "UK"
        Then the response status code should be 200
         And I should be on "/uk/faq"

    Scenario: Switch from english language to russian
        Given I am on "/en/faq"
        When I follow "RU"
        Then the response status code should be 200
         And I should be on "/ru/faq"

    Scenario: Switch from ukraine language to russian
        Given I am on "/uk/faq"
        When I follow "RU"
        Then the response status code should be 200
         And I should be on "/ru/faq"
