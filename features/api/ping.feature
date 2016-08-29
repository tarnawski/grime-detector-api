Feature: Status
  In order to have possibility to check that API is responsible
  As a user
  I need to be able ping api

  Scenario: Ping api
    When I send a GET request to "/ping"
    Then the response code should be 200
    And the JSON response should match:
    """
    [
      "pong"
    ]
    """