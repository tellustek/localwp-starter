#!/bin/bash
rm -rf ../app/public/wp-content/plugins
rm -rf ../app/public/wp-content/themes

# 建立符號鏈結
ln -fs "`pwd`/public/wp-content/plugins" ../app/public/wp-content/plugins
ln -fs "`pwd`/public/wp-content/themes" ../app/public/wp-content/themes
