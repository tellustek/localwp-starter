#!/bin/bash
rm ../app/public/wp-content/plugins
rm ../app/public/wp-content/themes

# 建立符號鏈結
ln -fs ./public/wp-content/plugins ../app/public/wp-content/plugins
ln -fs ./public/wp-content/themes ../app/public/wp-content/themes