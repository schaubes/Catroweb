@web @achievements
Feature: Owner should get linguist achievement when projects have custom translations for five languages

  Background:
    Given I run the update achievements command
    And there are users:
      | name     |
      | Catrobat |
    And there are projects:
      | id | name      | owned by |
      | 1  | project 1 | Catrobat |
      | 2  | project 2 | Catrobat |
      | 3  | project 3 | Catrobat |
      | 4  | project 4 | Catrobat |
      | 5  | project 5 | Catrobat |

  Scenario: Owner should get achievement when one project has custom translations for five languages
    Given I POST login with user "Catrobat" and password "123456"
    And I request "PUT" "/app/translate/custom/project/1?field=name&language=fr&text=translated"
    And I request "PUT" "/app/translate/custom/project/1?field=description&language=es&text=translated"
    And I request "PUT" "/app/translate/custom/project/1?field=credit&language=it&text=translated"
    And I request "PUT" "/app/translate/custom/project/1?field=name&language=de&text=translated"
    And I request "PUT" "/app/translate/custom/project/1?field=description&language=ar&text=translated"
    When I log in as "Catrobat"
    And I am on "/app/achievements"
    And I wait for the page to be loaded
    Then the "#unlocked-achievements" element should contain "Linguist"

  Scenario: Owner should get achievement when five projects each have a custom translations for a different language
    Given I POST login with user "Catrobat" and password "123456"
    And I request "PUT" "/app/translate/custom/project/1?field=name&language=fr&text=translated"
    And I request "PUT" "/app/translate/custom/project/2?field=description&language=es&text=translated"
    And I request "PUT" "/app/translate/custom/project/3?field=credit&language=it&text=translated"
    And I request "PUT" "/app/translate/custom/project/4?field=name&language=de&text=translated"
    And I request "PUT" "/app/translate/custom/project/5?field=description&language=ar&text=translated"
    When I log in as "Catrobat"
    And I am on "/app/achievements"
    And I wait for the page to be loaded
    Then the "#unlocked-achievements" element should contain "Linguist"

  Scenario: Owner should not get achievement when five projects have a custom translations for the same language
    Given I POST login with user "Catrobat" and password "123456"
    And I request "PUT" "/app/translate/custom/project/1?field=credit&language=fr&text=translated"
    And I request "PUT" "/app/translate/custom/project/2?field=name&language=fr&text=translated"
    And I request "PUT" "/app/translate/custom/project/3?field=name&language=fr&text=translated"
    And I request "PUT" "/app/translate/custom/project/4?field=name&language=fr&text=translated"
    And I request "PUT" "/app/translate/custom/project/5?field=name&language=fr&text=translated"
    When I log in as "Catrobat"
    And I am on "/app/achievements"
    And I wait for the page to be loaded
    Then the "#unlocked-achievements" element should not contain "Linguist"

