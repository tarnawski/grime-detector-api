Feature: Check text
  In order to have possibility to check text
  As a user
  I need to be able to check text and get response in specific format

  Background:
    Given There are the following words:
      | NAME   | POSITIVE | NEGATIVE |
      | stupid |    0     |    1     |
      | super  |    1     |    0     |

  @cleanDB
  Scenario: Check negative text
    When I send a POST request to "/check" with body:
    """
    {
      "text": "stupid"
    }
    """
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "status": "NEGATIVE"
    }
    """

  @cleanDB
  Scenario: Check positive text
    When I send a POST request to "/check" with body:
    """
    {
      "text": "super"
    }
    """
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "status": "POSITIVE"
    }
    """

  @cleanDB
  Scenario: Check negative text and complex output
    When I send a POST request to "/check" with body:
    """
    {
      "text": "stupid",
      "output": "complex"
    }
    """
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "text": "stupid",
      "probability": 0.99,
      "threshold": 0.5,
      "status": "NEGATIVE"
    }
    """

  @cleanDB
  Scenario: Check neutral text and custom threshold
    When I send a POST request to "/check" with body:
    """
    {
        "text": "neutral",
        "threshold": 0.49,
        "output": "complex"
    }
    """
    Then the response code should be 200
    And the JSON response should match:
    """
    {
      "text": "neutral",
      "probability": 0.5,
      "threshold": 0.49,
      "status": "NEGATIVE"
    }
    """