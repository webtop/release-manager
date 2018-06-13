const webpackConfig = require('./webpack.config');

module.exports = function(grunt) {
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		webpack: {
		    options: {
		        stats: !process.env.NODE_ENV || process.env.NODE_ENV === 'development'
		    },
		    dev: webpackConfig
		},
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			build: {
				src: 'src/assets/js/bundle.js',
				dest: 'public/js/<%= pkg.name %>.min.js'
			}
		},
		less: {
			allTargets: {
				files: {
					'public/css/<%= pkg.name %>.min.css': 'src/assets/css/style.less',
				}
			},
			options: {
				compress: true,
				ieCompat: true,
			}
		},
		watch: {
			webpack: {
				files: ['src/assets/js/components/*.js'],
				tasks: ['webpack']
			},
			uglify: {
				files: 'src/assets/js/bundle.js',
				tasks: ['uglify']
			},
			less: {
				files: 'src/assets/css/**/*.less',
				tasks: ['less']
			}
		}
	});

	grunt.loadNpmTasks('grunt-webpack');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['watch']);

};
