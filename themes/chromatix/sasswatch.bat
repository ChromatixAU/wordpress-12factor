@echo off
echo Watching for changes to SCSS files in:
cd
echo Press Ctrl+C to exit.
sass --watch sass/styles.scss:css/styles.css sass/admin-generic.scss:css/admin-generic.css sass/admin-login.scss:css/admin-login.css sass/editorstyles.scss:editor-style-shared.css -r ./sass/_sass_functions.rb --style compressed

rem useful switches:
rem --line-comments
rem --style compressed
rem --watch
rem -r ./_sass_functions.rb