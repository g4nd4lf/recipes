module.exports = function(grunt)
{
    grunt.initConfig({
        npmcopy: {
            options: {
                clean: false,
                srcPrefix: 'node_modules/'
            },
            default: {
                files: {
                    'js/jquery.js': 'jquery/dist/jquery.min.js',
                    'js/foundation.js': 'foundation-sites/dist/foundation.min.js'
                }
            },
        },
        uglify: {
            default: {
                files: [
                    { src: 'js/src/*.js', dest: 'js/app.js' }
                ]
            },
        },
        sass: {
            options: {
                includePaths: [
                    'node_modules/foundation-sites/scss/',
                    'node_modules/components-font-awesome/scss/'
                ],
                outputStyle: 'compressed',
                sourceMap: false
            },
            dist: {
                files: {
                    'css/app.css': 'sass/app.scss'
                }
            }
        },
        watch: {
            sass: {
                files: ['sass/*'],
                tasks: ['sass']
            },
            js: {
                files: ['js/src/*'],
                tasks: ['uglify']
            }
        }
    });
    grunt.loadNpmTasks('grunt-npmcopy');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', ['sass', 'npmcopy', 'uglify']);
};
