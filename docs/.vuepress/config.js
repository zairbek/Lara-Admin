module.exports = {
	base: '/backend/packages/lara-admin/',
	title: 'Laravel Admin',
	description: '',
	host: 'localhost',
	port: 3001,
	dest: 'public',
	themeConfig: {
		nav: [
			{ text: 'Home', link: '/' },
			{ text: 'GitLab', link: 'https://gitlab.com/future-group/backend/packages/lara-admin' },
		],
		sidebar: [
			'/',
			'/structs',
		],
		displayAllHeaders: true,
		sidebarDepth: 2
	}
};