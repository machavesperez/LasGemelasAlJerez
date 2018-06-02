import pandas as pd
import numpy as np
import pandas
import os
# Calcular la sumas de las columnas
# https://stackoverflow.com/questions/41286569/get-total-of-pandas-column

from jinja2 import Environment, FileSystemLoader	# Templating
#from weasyprint import HTML 						# Generating PDF
#from headless_pdfkit import generate_pdf
import pdfkit

# Constantes globales
EXCEL_OUTPUT = "output.xlsx"
EXCEL_EVENTO = "evento.xlsx"
EXCEL_MENU 	 = "menu.xlsx"
EXCEL_RECETA = "receta.xlsx"

SHEET_PRINCIPAL 	= 0
SHEET_PRODUCTOS 	= 1
SHEET_BEBIDAS 		= 2
SHEET_MATERIALES	= 3
SHEET_TRABAJADORES 	= 4


# API:
# def printPDF (html_out:str)
# def printListaCompraReceta ()
# def printListaCompraMenu ()
# def printListaCompraEvento ()
# def printBeneficioReceta ()
# def printBeneficioMenu ()
# def printBeneficioEvento ()

def printPDF (html_out: str, file_name: str):
	html_out  = str(html_out)
	file_name = str(file_name)
# Generate PDF (pdfkit)
	this_dir, this_filename = os.path.split(__file__)
	pdfkit.from_string(html_out, file_name, css=[this_dir+'/templates/typography.css'])


# Generate PDF (headless pdfkit)
	# pdf_out = generate_pdf(html_out)
	# with open('evento.pdf', 'wb') as w:
	# 	w.write(pdf_out)
	# 	w.close()

# Generate PDF Weasyprint
	#HTML(string=html_out).write_pdf("evento.pdf", stylesheets=["typography.css"])

def printListaCompraReceta (): 

	# Get name of 
	str_tituloReceta = pd.ExcelFile(EXCEL_RECETA).sheet_names[0]

	# Read Excel sheet to DataFrame
	df_principal 	 = pandas.read_excel(io=EXCEL_RECETA, sheet_name=SHEET_PRINCIPAL)
	df_productos  	 = pandas.read_excel(io=EXCEL_RECETA, sheet_name=SHEET_PRODUCTOS)

	# Eliminación de columnas de Productos
	del df_productos['PrecioCompra/Unidad']
	del df_productos['PrecioVenta/Unidad']
	del df_productos['Coste']
	del df_productos['BeneficioBruto']
	del df_productos['BeneficioNeto'] 

	# Write dataframe to excel file
	writer = pd.ExcelWriter('output.xlsx')
	df_principal.to_excel	(excel_writer=writer, sheet_name=str_tituloReceta)
	df_productos.to_excel	(excel_writer=writer, sheet_name='Productos')
	writer.save()

	# Templating
	this_dir, this_filename = os.path.split(__file__)
	env = Environment(loader=FileSystemLoader(searchpath=this_dir+'/templates/'))
	template = env.get_template('template_receta.html')

	template_vars = {
		"Receta":			str_tituloReceta,
		"Titulo": 			"Lista compra de la Receta: " + str_tituloReceta,
		"Productos": 		df_productos.to_html	(na_rep="", justify='center')
	}

	html_out = template.render(template_vars)

	# Print PDF
	printPDF(html_out, 'receta.pdf')

def printListaCompraMenu (): 

	# Get name of 
	str_tituloMenu = pd.ExcelFile(EXCEL_MENU).sheet_names[0]

	# Read Excel sheet to DataFrame
	df_principal 	 = pandas.read_excel(io=EXCEL_MENU, sheet_name=SHEET_PRINCIPAL)
	df_productos  	 = pandas.read_excel(io=EXCEL_MENU, sheet_name=SHEET_PRODUCTOS)
	df_bebidas	 	 = pandas.read_excel(io=EXCEL_MENU, sheet_name=SHEET_BEBIDAS)

	# Eliminación de columnas de Productos
	del df_productos['PrecioCompra/Unidad']
	del df_productos['PrecioVenta/Unidad']
	del df_productos['Coste']
	del df_productos['BeneficioBruto']
	del df_productos['BeneficioNeto'] 

	# Eliminación de columnas de Bebidas
	del df_bebidas['PrecioCompra/Unidad']
	del df_bebidas['PrecioVenta/Unidad']
	del df_bebidas['Coste']
	del df_bebidas['BeneficioBruto']
	del df_bebidas['BeneficioNeto'] 

	# Write dataframe to excel file
	writer = pd.ExcelWriter('output.xlsx')
	df_principal.to_excel	(excel_writer=writer, sheet_name=str_tituloMenu)
	df_productos.to_excel	(excel_writer=writer, sheet_name='Productos')
	df_bebidas.to_excel		(excel_writer=writer, sheet_name='Bebidas')
	writer.save()

	# Templating
	this_dir, this_filename = os.path.split(__file__)
	env = Environment(loader=FileSystemLoader(searchpath=this_dir+'/templates/'))
	template = env.get_template('template_menu.html')


	template_vars = {
		"Menu":				str_tituloMenu,
		"Titulo": 			"Lista compra del Menú: " + str_tituloMenu,
		"Productos": 		df_productos.to_html	(na_rep="", justify='center'),
		"Bebidas": 			df_bebidas.to_html		(na_rep="", justify='center')
	}

	html_out = template.render(template_vars)

	# Print PDF
	printPDF(html_out, 'menu.pdf')


def printListaCompraEvento (): 

	# Get name of 
	str_tituloEvento = pd.ExcelFile(EXCEL_EVENTO).sheet_names[0]

	# Read Excel sheet to DataFrame
	df_principal 	 = pandas.read_excel(io=EXCEL_EVENTO, sheet_name=SHEET_PRINCIPAL)
	df_productos  	 = pandas.read_excel(io=EXCEL_EVENTO, sheet_name=SHEET_PRODUCTOS)
	df_bebidas	 	 = pandas.read_excel(io=EXCEL_EVENTO, sheet_name=SHEET_BEBIDAS)
	df_materiales	 = pandas.read_excel(io=EXCEL_EVENTO, sheet_name=SHEET_MATERIALES)

	# Eliminación de columnas de Productos
	del df_productos['PrecioCompra/Unidad']
	del df_productos['PrecioVenta/Unidad']
	del df_productos['Coste']
	del df_productos['BeneficioBruto']
	del df_productos['BeneficioNeto'] 

	# Eliminación de columnas de Bebidas
	del df_bebidas['PrecioCompra/Unidad']
	del df_bebidas['PrecioVenta/Unidad']
	del df_bebidas['Coste']
	del df_bebidas['BeneficioBruto']
	del df_bebidas['BeneficioNeto'] 

	# Eliminación de columnas de Materiales
	del df_materiales['PrecioCompra/Unidad']
	del df_materiales['PrecioVenta/Unidad']
	del df_materiales['Coste']
	del df_materiales['BeneficioBruto']
	del df_materiales['BeneficioNeto'] 

	# Write dataframe to excel file
	writer = pd.ExcelWriter('output.xlsx')
	df_principal.to_excel	(excel_writer=writer, sheet_name=str_tituloEvento)
	df_productos.to_excel	(excel_writer=writer, sheet_name='Productos')
	df_bebidas.to_excel		(excel_writer=writer, sheet_name='Bebidas')
	df_materiales.to_excel	(excel_writer=writer, sheet_name='Materiales')
	writer.save()

	# Templating
	this_dir, this_filename = os.path.split(__file__)
	env = Environment(loader=FileSystemLoader(searchpath=this_dir+'/templates/'))
	template = env.get_template('template_evento.html')

	template_vars = {
		"Evento":			str_tituloEvento,
		"Titulo": 			"Lista compra del Evento: " + str_tituloEvento,
		"Productos": 		df_productos.to_html	(na_rep="", justify='center'),
		"Bebidas": 			df_bebidas.to_html		(na_rep="", justify='center'),
		"Materiales":		df_materiales.to_html	(na_rep="", justify='center')
	}

	html_out = template.render(template_vars)

	# Print PDF
	printPDF(html_out, 'evento.pdf')


def printBeneficioReceta ():

	# Get name of 
	str_tituloReceta = pd.ExcelFile(EXCEL_RECETA).sheet_names[0]

	# Read Excel sheet to DataFrame
	df_principal 	 = pandas.read_excel(io=EXCEL_RECETA, sheet_name=SHEET_PRINCIPAL)
	df_productos  	 = pandas.read_excel(io=EXCEL_RECETA, sheet_name=SHEET_PRODUCTOS)

	# Calculo de totales de Productos
	df_productos.at['Total Coste',           'Coste'] 			= str(df_productos['Coste'].sum())
	df_productos.at['Total Beneficio Bruto', 'BeneficioBruto'] 	= str(df_productos['BeneficioBruto'].sum())
	df_productos.at['Total Beneficio Neto',  'BeneficioNeto']  	= str(df_productos['BeneficioNeto'].sum())

	# Write dataframe to excel file
	writer = pd.ExcelWriter('output.xlsx')
	df_principal.to_excel	(excel_writer=writer, sheet_name=str_tituloReceta)
	df_productos.to_excel	(excel_writer=writer, sheet_name='Productos')
	writer.save()

	# Templating
	this_dir, this_filename = os.path.split(__file__)
	env = Environment(loader=FileSystemLoader(searchpath=this_dir+'/templates/'))
	template = env.get_template('template_receta.html')

	template_vars = {
		"Receta":			str_tituloReceta,
		"Titulo": 			"Beneficio de la Reeta: " + str_tituloReceta,
		"Productos": 		df_productos.to_html(na_rep="", justify='center'),
	}

	html_out = template.render(template_vars)

	# Print PDF
	printPDF(html_out, 'receta.pdf')


def printBeneficioMenu ():

	# Get name of 
	str_tituloMenu = pd.ExcelFile(EXCEL_MENU).sheet_names[0]

	# Read Excel sheet to DataFrame
	df_principal 	 = pandas.read_excel(io=EXCEL_MENU, sheet_name=SHEET_PRINCIPAL)
	df_productos  	 = pandas.read_excel(io=EXCEL_MENU, sheet_name=SHEET_PRODUCTOS)
	df_bebidas	 	 = pandas.read_excel(io=EXCEL_MENU, sheet_name=SHEET_BEBIDAS)

	# Calculo de totales de Productos
	df_productos.at['Total Coste',           	'Coste'] 			= str(df_productos['Coste'].sum())
	df_productos.at['Total Beneficio Bruto', 	'BeneficioBruto'] 	= str(df_productos['BeneficioBruto'].sum())
	df_productos.at['Total Beneficio Neto',  	'BeneficioNeto']  	= str(df_productos['BeneficioNeto'].sum())

	# Calculo de totales de Bebidas
	df_bebidas.at['Total Coste',           		'Coste'] 			= str(df_bebidas['Coste'].sum())
	df_bebidas.at['Total Beneficio Bruto', 		'BeneficioBruto'] 	= str(df_bebidas['BeneficioBruto'].sum())
	df_bebidas.at['Total Beneficio Neto',  		'BeneficioNeto']  	= str(df_bebidas['BeneficioNeto'].sum())

	# Write dataframe to excel file
	writer = pd.ExcelWriter('output.xlsx')
	df_principal.to_excel	(excel_writer=writer, sheet_name=str_tituloMenu)
	df_productos.to_excel	(excel_writer=writer, sheet_name='Productos')
	df_bebidas.to_excel		(excel_writer=writer, sheet_name='Bebidas')
	writer.save()

	# Templating
	this_dir, this_filename = os.path.split(__file__)
	env = Environment(loader=FileSystemLoader(searchpath=this_dir+'/templates/'))
	template = env.get_template('template_menu.html')

	template_vars = { 
		"Menu":			str_tituloMenu,
		"Titulo": 		"Beneficio del Menú: " + str_tituloMenu,
		"Productos": 	df_productos.to_html(na_rep="", justify='center'),
		"Bebidas": 		df_bebidas.to_html	(na_rep="", justify='center'),
	}

	html_out = template.render(template_vars)

	# Print PDF
	printPDF(html_out, 'menu.pdf')


def printBeneficioEvento ():

	# Get name of 
	str_tituloEvento = pd.ExcelFile(EXCEL_EVENTO).sheet_names[0]

	# Read Excel sheet to DataFrame
	df_principal 	 = pandas.read_excel(io=EXCEL_EVENTO, sheet_name=SHEET_PRINCIPAL)
	df_productos  	 = pandas.read_excel(io=EXCEL_EVENTO, sheet_name=SHEET_PRODUCTOS)
	df_bebidas	 	 = pandas.read_excel(io=EXCEL_EVENTO, sheet_name=SHEET_BEBIDAS)
	df_materiales	 = pandas.read_excel(io=EXCEL_EVENTO, sheet_name=SHEET_MATERIALES)
	df_trabajadores  = pandas.read_excel(io=EXCEL_EVENTO, sheet_name=SHEET_TRABAJADORES)

	# Calculo de totales de Productos
	df_productos.at['Total Coste',           	'Coste'] 			= str(df_productos['Coste'].sum())
	df_productos.at['Total Beneficio Bruto', 	'BeneficioBruto'] 	= str(df_productos['BeneficioBruto'].sum())
	df_productos.at['Total Beneficio Neto',  	'BeneficioNeto']  	= str(df_productos['BeneficioNeto'].sum())

	# Calculo de totales de Bebidas
	df_bebidas.at['Total Coste',           		'Coste'] 			= str(df_bebidas['Coste'].sum())
	df_bebidas.at['Total Beneficio Bruto', 		'BeneficioBruto'] 	= str(df_bebidas['BeneficioBruto'].sum())
	df_bebidas.at['Total Beneficio Neto',  		'BeneficioNeto']  	= str(df_bebidas['BeneficioNeto'].sum())

	# Calculo de totales de Materiales
	df_materiales.at['Total Coste',           	'Coste'] 			= str(df_materiales['Coste'].sum())
	df_materiales.at['Total Beneficio Bruto', 	'BeneficioBruto'] 	= str(df_materiales['BeneficioBruto'].sum())
	df_materiales.at['Total Beneficio Neto',  	'BeneficioNeto']  	= str(df_materiales['BeneficioNeto'].sum())

	# Calculo de totales de Trabajadores
	df_trabajadores.at['Total Coste',  			'Coste'] 			= str(df_trabajadores['Coste'].sum())

	# Write dataframe to excel file
	writer = pd.ExcelWriter('output.xlsx')
	df_principal.to_excel	(excel_writer=writer, sheet_name=str_tituloEvento)
	df_productos.to_excel	(excel_writer=writer, sheet_name='Productos')
	df_bebidas.to_excel		(excel_writer=writer, sheet_name='Bebidas')
	df_materiales.to_excel	(excel_writer=writer, sheet_name='Materiales')
	df_trabajadores.to_excel(excel_writer=writer, sheet_name='Trabajadores')
	writer.save()

	# Templating
	this_dir, this_filename = os.path.split(__file__)
	env = Environment(loader=FileSystemLoader(searchpath=this_dir+'/templates/'))
	template = env.get_template('template_evento.html')

	template_vars = {
		"Evento":			str_tituloEvento,
		"Titulo": 			"Beneficio del Evento: " + str_tituloEvento,
		"Productos": 		df_productos.to_html	(na_rep="", justify='center'),
		"Bebidas": 			df_bebidas.to_html		(na_rep="", justify='center'),
		"Materiales":		df_materiales.to_html	(na_rep="", justify='center'),
		"Trabajadores": 	df_trabajadores.to_html	(na_rep="", justify='center')
	}

	html_out = template.render(template_vars)

	# Print PDF
	printPDF(html_out, 'evento.pdf')





