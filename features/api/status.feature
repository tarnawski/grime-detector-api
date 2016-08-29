Feature: Check status
  In order to have possibility to check API status
  As a user
  I need to be able to show basic statistic from API

  Background:
    Given There are the following statistic:
      | KEY           | NAME                    | VALUE   |
      | TEXT_CHECKED  | Number of checked text  |  125    |
      | LEARNING_DATA | Number of learning data |  81     |
      | EFFICIENCY    | Efficiency              |  62.84  |

  @cleanDB
  Scenario: Get status
    When I send a GET request to "/status"
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "checked": "@string@",
      "training_data": "@string@",
      "efficiency": "@string@"
    }
    """
