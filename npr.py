import numpy as np
import matplotlib.pyplot as plt
import cv2 as cv
import easyocr
import imutils
import sys
import warnings

if not sys.warnoptions:
    warnings.simplefilter("ignore")

img=cv.imread('./npr-images/'+sys.argv[1])
bw=cv.cvtColor(img,cv.COLOR_BGR2GRAY)
bf=cv.bilateralFilter(bw,20,60,60)
edge=cv.Canny(bf,25,250)
coordinates=cv.findContours(edge.copy(),cv.RETR_TREE,cv.CHAIN_APPROX_SIMPLE)
contours=imutils.grab_contours(coordinates)
contours=sorted(contours,key=cv.contourArea,reverse=True)[:10]
position=None

for contour in contours:
    approx=cv.approxPolyDP(contour,10,True)
    if len(approx)==4:
        position=approx
        break
    
mask=np.zeros(bw.shape,np.uint8)
masked_img=cv.drawContours(mask,[position],0,255,-1)
masked_img=cv.bitwise_and(img,img,mask=mask)
(x,y) = np.where(mask==255)
(x1, y1) = (np.min(x), np.min(y))
(x2, y2) = (np.max(x), np.max(y))
number_plate = bw[x1:x2+1, y1:y2+1]
reader = easyocr.Reader(['en'])
result = reader.readtext(number_plate)
number=result[0][1]
print(number)