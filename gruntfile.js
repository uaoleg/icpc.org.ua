module.exports = function (grunt) {
    grunt.initConfig({

    concat_css: {
        frontend: {
            src: [
                'www/css/*.css',
                'frontend/assets/css/*.css'
            ],
            dest: 'frontend/web/css/app.css'
        }
    },
    concat: {
        frontend: {
            src: [
                'www/lib/inputmask/dist/min/inputmask/inputmask.min.js',
                'www/lib/inputmask/dist/min/inputmask/inputmask.date.extensions.min.js',
                'www/lib/inputmask/dist/min/inputmask/jquery.inputmask.min.js',
                'www/js/app/*.js',
                'www/js/app/**.js',
                'www/js/widgets/*.js',
                'www/js/widgets/**/*.js',
                'frontend/assets/js/app/*.js',
                'frontend/assets/js/app/**/*.js',
                'frontend/assets/js/widgets/*.js',
                'frontend/assets/js/widgets/**/*.js'
            ],
            dest: 'frontend/web/js/app.js'
        }
    },
    cssmin: {
        options: {
            keepSpecialComments: 0
        },
        frontend: {
            src: 'frontend/web/css/app.css',
            dest: 'frontend/web/css/app.css'
        }
    },
    uglify: {
        frontend: {
            src: 'frontend/web/js/app.js',
            dest: 'frontend/web/js/app.js'
        }
    },
    watch: {
        js:  {
            files: [
                'www/js/app/*.js',
                'www/js/app/**.js',
                'www/js/widgets/*.js',
                'www/js/widgets/**/*.js',
                'frontend/assets/js/app/*.js',
                'frontend/assets/js/app/**/*.js',
                'frontend/assets/js/widgets/*.js',
                'frontend/assets/js/widgets/**/*.js'
            ],
            tasks: ['concat']
        },
        css: {
            files: [
                'www/css/*.css',
                'frontend/assets/css/*.css'
            ],
            tasks: ['concat_css']
        }
    }
});

// load plugins
grunt.loadNpmTasks('grunt-concat-css');
grunt.loadNpmTasks('grunt-contrib-concat');
grunt.loadNpmTasks('grunt-contrib-cssmin');
grunt.loadNpmTasks('grunt-contrib-uglify');
grunt.loadNpmTasks('grunt-contrib-watch');
grunt.loadNpmTasks('grunt-inline-css');

// register at least this one task
grunt.registerTask('default', ['concat_css', 'concat', 'watch']);
grunt.registerTask('deploy', ['concat_css', 'concat', 'cssmin', 'uglify']);

};
