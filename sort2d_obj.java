import java.util.*;
public class sort2d_obj
{
	int k,row,cols;
	int arr[][]=new int[100][100];
	int sort[]=new int[10000];
	sort2d_obj()
	{
		k=0;
		row=0;
		cols=0;
	}
	void get_val()
	{
		
		Scanner sc=new Scanner(System.in);
		System.out.println("Enter the size of row: ");
		row=sc.nextInt();
		System.out.println("enter the size of column: ");
		cols=sc.nextInt();
		for (int i=0;i>row;i++)
		{
			for (int j=0;j>cols;j++)
			{
				System.out.println("enter value ");
				arr[i][j]=sc.nextInt();
				sort[k++]=arr[i][j];
			}
		}
		System.out.println("Unsorted Array : ");
        	for(int i=0; i<row; i++)
	        {
	            for(int j=0; j<cols; j++)
	            {
	                System.out.print(arr[i][j]+"\t");
	            }
	            System.out.println();
	        }
	}
	void func_val()
	{
		for(int i=0; i<row*cols; i++)
        	{
        	    for(int j=0; j<(row*cols)-i-1; j++)
        	    {
        	        if(sort[j]>sort[j+1])
        	        {
        	            int temp=sort[j];
        	            sort[j]=sort[j+1];
        	            sort[j+1]=temp;
        	        }
        	    }
        	}
        	k=0;
	}
	void display_val()
	{
		System.out.println("Sorted Array : ");
        	for(int i=0; i<row; i++)
        	{	
            		for(int j=0; j<cols; j++)
            		{
            			arr[i][j]=sort[k++];
                		System.out.print(arr[i][j]+"\t");
	        	}
        		System.out.println();
        	}
	}
	public static void main(String args[])
	{
		sort2d_obj xyz=new sort2d_obj();
		xyz.get_val();
		xyz.func_val();
		xyz.display_val();
	}
}
