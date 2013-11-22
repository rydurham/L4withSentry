# Code Coverage Guidelines

### Automatic Visual Code Coverage (using Sublime Text)
If you use SublimeText as your editor, you can automatically visualize code coverage using the [Sublime Code Coverage package](https://github.com/bradfeehan/SublimePHPCoverage) and the [Sublime Build on Save package](https://github.com/alexnj/SublimeOnSaveBuild).

1. Install both Sublime packages.
2. Go to Preferences &gt; Settings - User and add the following settings:

    ```javascript
    "binary_file_patterns":
    [
          "vendor/*"
    ]
    ```

3. Create a file in the root of the L4withSentry project called `l4withsentry.sublime-project` and put the following in it, replacing `/usr/local/php5/bin` with your php path.

  ```javascript
  {
      "folders":
      [
          {
              "path": "./"
          }
      ],
      "settings":
      {
          "filename_filter": "\\.(php|.html.blade)$",
          "build_on_save": 1
      },
      "build_systems":
      [
          {
              "name": "PHPUNIT",
              "path": "/usr/local/php5/bin",
              "cmd": [
                  "$project_path/vendor/bin/phpunit",
                  "--coverage-clover=$project_path/build/logs/clover.xml",
                  "--configuration=$project_path/phpunit.xml"
              ]
          }
      ]
  }
  ```
  
4. Restart Sublime Text
5. Reopen L4withSentry using these steps:
  1. Go to Project &gt; Open Project...
  2. Select the `l4withsentry.sublime-project` that you created above.
6. Manually build the project
  1. Tools &gt; Build System, make sure PHPUNIT is selected
  2. Click Tools &gt; Build to run phpunit against the project and generate initial coverage files.
7.  You should now be able to open app/controllers/UserController.php and visually see the what code is covered by tests and what code is not.

Note: If a file is not referenced at all in a test, then it will not have any visual indicators in it. To start seeing visual indicators, write a test that covers some part of this file.