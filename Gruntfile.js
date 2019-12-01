module.exports = function(grunt) {
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			options: {
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
			},
			build: {
				src: 'src/assets/js/*.js',
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
			uglify: {
				files: 'src/assets/js/*.js',
				tasks: ['uglify']
			},
			less: {
				files: 'src/assets/css/**/*.less',
				tasks: ['less']
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-uglify-es');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['watch']);

};
